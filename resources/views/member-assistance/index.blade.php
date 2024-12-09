<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escáner QR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col items-center justify-start p-4">
<div class="w-full max-w-4xl bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-center mb-6">Asistencia</h2>

        <div x-data="{ activeTab: 'text' }" class="mb-6">
            <div class="flex border-b border-gray-200">
                <button @click="activeTab = 'text'" :class="{'border-b-2 border-blue-500': activeTab === 'text'}" class="flex-1 py-2 px-4 text-center">Texto</button>
                <button @click="activeTab = 'camera'; startScanner()" :class="{'border-b-2 border-blue-500': activeTab === 'camera'}" class="flex-1 py-2 px-4 text-center">Cámara</button>
            </div>

            <div x-show="activeTab === 'text'" class="mt-4">
                <form action="{{ route('member-assistance.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="token" placeholder="Ingrese token" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('token')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Enviar</button>
                </form>
            </div>

            <div x-show="activeTab === 'camera'" class="mt-4">
                <div id="reader" class="w-full"></div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora de Registro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado de Membresía</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($records as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $record->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $record->created_at->format('Y-d-m H:m:s') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($record->user->membership->status === 'active')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ACTIVO
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    INACTVO
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let html5QrcodeScanner;

    function onScanSuccess(decodedText, decodedResult) {
        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
        }

        console.log(`Texto decodificado: ${decodedText}`);

        fetch('{{ route("member-assistance.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ token: decodedText })
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Asistencia registrada correctamente') {
                    window.location.reload();
                } else {
                    let errorMessage = 'Error al registrar la asistencia';
                    if (data.errors && data.errors.token) {
                        errorMessage = data.errors.token.join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage
                    });
                    if (submitButton) {
                        submitButton.disabled = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.'
                });
                if (submitButton) {
                    submitButton.disabled = false;
                }
            });
    }

    function onScanFailure(error) {
        console.warn(`Error al escanear el código: ${error}`);
    }

    function startScanner() {
        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10
                },
                false
            );

            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }
    }

    function stopScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(() => {
                const readerElement = document.getElementById('reader');
                if (readerElement) {
                    readerElement.remove();
                }
            }).catch(err => {
                console.error(`Error al detener el escáner de códigos QR: ${err}`);
            });
        }
    }

    function scannerTranslator() {
        const traducciones = [
            {original: "QR code parse error, error =", traduccion: "Error al analizar el código QR, error ="},
            {original: "Error getting userMedia, error =", traduccion: "Error al obtener userMedia, error ="},
            {original: "The device doesn't support navigator.mediaDevices , only supported cameraIdOrConfig in this case is deviceId parameter (string).", traduccion: "El dispositivo no admite navigator.mediaDevices, en este caso sólo se admite cameraIdOrConfig como parámetro deviceId (cadena)."},
            {original: "Camera streaming not supported by the browser.", traduccion: "El navegador no admite la transmisión de la cámara."},
            {original: "Unable to query supported devices, unknown error.", traduccion: "No se puede consultar los dispositivos compatibles, error desconocido."},
            {original: "Camera access is only supported in secure context like https or localhost.", traduccion: "El acceso a la cámara sólo es compatible en un contexto seguro como https o localhost."},
            {original: "Scanner paused", traduccion: "Escáner en pausa"},
            {original: "Scanning", traduccion: "Escaneando"},
            {original: "Idle", traduccion: "Inactivo"},
            {original: "Error", traduccion: "Error"},
            {original: "Permission", traduccion: "Permiso"},
            {original: "No Cameras", traduaccion: "Sin cámaras"},
            {original: "Last Match:", traduccion: "Última coincidencia:"},
            {original: "Code Scanner", traduccion: "Escáner de código"},
            {original: "Request Camera Permissions", traduccion: "Solicitar permisos de cámara"},
            {original: "Requesting camera permissions...", traduccion: "Solicitando permisos de cámara..."},
            {original: "No camera found", traduccion: "No se encontró ninguna cámara"},
            {original: "Stop Scanning", traduccion: "Detener escaneo"},
            {original: "Start Scanning", traduccion: "Iniciar escaneo"},
            {original: "Switch On Torch", traduccion: "Encender linterna"},
            {original: "Switch Off Torch", traduccion: "Apagar linterna"},
            {original: "Failed to turn on torch", traduccion: "Error al encender la linterna"},
            {original: "Failed to turn off torch", traduccion: "Error al apagar la linterna"},
            {original: "Launching Camera...", traduccion: "Iniciando cámara..."},
            {original: "Scan an Image File", traduccion: "Escanear un archivo de imagen"},
            {original: "Scan using camera directly", traduccion: "Escanear usando la cámara directamente"},
            {original: "Select Camera", traduccion: "Seleccionar cámara"},
            {original: "Choose Image", traduccion: "Elegir imagen"},
            {original: "Choose Another", traduccion: "Elegir otra"},
            {original: "No image choosen", traduccion: "Ninguna imagen seleccionada"},
            {original: "Anonymous Camera", traduccion: "Cámara anónima"},
            {original: "Or drop an image to scan", traduccion: "O arrastra una imagen para escanear"},
            {original: "Or drop an image to scan (other files not supported)", traduccion: "O arrastra una imagen para escanear (otros archivos no soportados)"},
            {original: "zoom", traduccion: "zoom"},
            {original: "Loading image...", traduccion: "Cargando imagen..."},
            {original: "Camera based scan", traduccion: "Escaneo basado en cámara"},
            {original: "Fule based scan", traduccion: "Escaneo basado en archivo"},
            {original: "Powered by ", traduccion: "Desarrollado por "},
            {original: "Report issues", traduccion: "Informar de problemas"},
            {original: "NotAllowedError: Permission denied", traduccion: "Permiso denegado para acceder a la cámara"}
        ];

        function traducirTexto(texto) {
            const traduccion = traducciones.find(t => t.original === texto);
            return traduccion ? traduccion.traduccion : texto;
        }

        function traducirNodosDeTexto(nodo) {
            if (nodo.nodeType === Node.TEXT_NODE) {
                nodo.textContent = traducirTexto(nodo.textContent.trim());
            } else {
                for (let i = 0; i < nodo.childNodes.length; i++) {
                    traducirNodosDeTexto(nodo.childNodes[i]);
                }
            }
        }

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach((nodo) => {
                        traducirNodosDeTexto(nodo);
                    });
                }
            });
        });

        const config = {childList: true, subtree: true};
        observer.observe(document.body, config);

        traducirNodosDeTexto(document.body);
    }

    document.addEventListener('DOMContentLoaded', function () {
        scannerTranslator();
    });
</script>
</body>
</html>
