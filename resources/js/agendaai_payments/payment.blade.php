@extends('layouts.app')

@section('content')
    <h3>Pagamento do AgendaAi R$ {{ $payment->valor }}!</h3>

    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">QRCode do Pix:</h3>
                        <img id="pixImgQrCode" class="img-fluid mb-3" alt="QRCode Pix" src="{{ $payment->getQRCodeBase64() }}"
                            style="max-height: 285px; display: inline;">
                        <p class="card-text" style="color:red; font-size:12px; font-weight: bold;">Se já efetuou o
                            pagamento, já pode Seguir o passo a passo a baixo!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 text-center">
                <div class="card">
                    {{-- <img src="https://app.script4lol.com/img/banner.png" class="card-img-top" alt="Product Image"
                        style="height: 15rem;"> --}}
                    <div class="card-body">
                        <h3 class="card-title">Linha do Pix (Copia e Cola):</h3>
                        <input type="text" class="form-control mb-3" name="codigo-pix" id="codigo-pix"
                            value="{{ $payment->qr_code }}">
                        <button id="copy-button" class="btn btn-info" data-clipboard-target="#codigo-pix">Copiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <h2 class="mt-4">Agora que pagou você deve seguir o passo a passo</h2>
    <p>
        1 -Agora é só aproveitar
    </p>

    <script>
        const copyButton = new ClipboardJS("#copy-button");
        // Trate o sucesso da cópia
        copyButton.on("success", (e) => {
            alert("Conteúdo copiado para a área de transferência!");
            e.clearSelection();
        });

        // Trate os erros da cópia
        copyButton.on("error", (e) => {
            alert("Não foi possível copiar o conteúdo.");
        });
    </script>
@endsection