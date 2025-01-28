@extends('adminlte::page')

@section('title', 'Escanear QR para Producto')

@section('content_header')
    <h1>Escanear Código QR</h1>
@stop

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card card-outline card-info w-100" style="max-width: 600px;">
            <div class="card-header text-center">
                <h3 class="card-title">Escanea el código QR del producto</h3>
            </div>
            <div class="card-body text-center">
                {{-- Contenedor para la vista previa de la cámara --}}
                <div id="reader"></div>
                <p class="mt-3 text-muted">
                    Apunta la cámara hacia el código QR del producto para escanear.
                </p>
            </div>
            <div class="card-footer text-center">
                <button id="stopScan" class="btn btn-danger">Detener Escaneo</button>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .vh-100 {
            height: 100vh;
        }

        /* Estilos del contenedor del lector */
        #reader {
            width: 100%;
            height: 60vh;
            max-height: 500px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background: black;
            position: relative;
            overflow: hidden;
        }

        /* Estilos para el video dentro del lector */
        #reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        /* Ajustes para pantallas pequeñas */
        @media (max-width: 576px) {
            #reader {
                height: 50vh;
            }

            .card {
                border: none;
            }
        }
    </style>
@stop

@section('js')
    <!-- Incluir la biblioteca Html5-Qrcode desde CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.7/html5-qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const html5QrCode = new Html5Qrcode("reader");

            const qrCodeSuccessCallback = (qrCodeMessage) => {
                const cleanedMessage = qrCodeMessage.trim().replace(/^\uFEFF/, '');
                console.log("Contenido escaneado:", cleanedMessage);
                
                const regex = /Código:\s*(PROD-\d+)/i;
                const match = cleanedMessage.match(regex);
                
                if (match && match[1]) {
                    let codigo = match[1];
                    console.log("Código de producto extraído:", codigo);
                    
                    const numeroMatch = codigo.match(/PROD-0*(\d+)/i);
                    if (numeroMatch && numeroMatch[1]) {
                        const numero = numeroMatch[1];
                        console.log("Número de producto extraído:", numero);
                        
                        html5QrCode.stop().then(() => {
                            // Redirige a la ruta deseada con el número encontrado
                            window.location.href = `/sistemaInventarios/public/productos/${numero}`;
                        }).catch(err => {
                            console.error("Error al detener el escaneo:", err);
                            alert("Hubo un problema al detener el escaneo.");
                        });
                    } else {
                        console.warn("No se pudo extraer el número del código:", codigo);
                        alert("El código QR no contiene un número de producto válido.");
                    }
                } else {
                    console.warn("Formato de QR inválido:", cleanedMessage);
                    alert("El código QR no tiene un formato válido.");
                }
            };

            const qrCodeErrorCallback = (errorMessage) => {
            };

            // Opciones de configuración del escáner
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };

            // Obtener la lista de cámaras y elegir la trasera
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let cameraId = devices[0].id;
                    
                    for (const device of devices) {
                        if (
                            device.label.toLowerCase().includes('back') ||
                            device.label.toLowerCase().includes('rear') ||
                            device.label.toLowerCase().includes('env')
                        ) {
                            cameraId = device.id;
                            break;
                        }
                    }

                    // Inicia el escaneo con la cámara seleccionada
                    html5QrCode.start(
                        cameraId,
                        config,
                        qrCodeSuccessCallback,
                        qrCodeErrorCallback
                    ).catch(err => {
                        console.error("Error al iniciar el escaneo:", err);
                        alert("Hubo un problema al intentar acceder a la cámara.");
                    });
                } else {
                    alert("No se encontraron cámaras disponibles.");
                }
            }).catch(err => {
                console.error("Error al obtener las cámaras:", err);
                alert("Hubo un problema al intentar acceder a las cámaras.");
            });

            document.getElementById('stopScan').addEventListener('click', function () {
                html5QrCode.stop().then(() => {
                    alert("Escaneo detenido.");
                }).catch(err => {
                    console.error("Error al detener el escaneo:", err);
                });
            });
        });
    </script>
@stop
