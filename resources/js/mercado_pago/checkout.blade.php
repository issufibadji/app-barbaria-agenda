<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
<script src="https://sdk.mercadopago.com/js/v2"></script>

@csrf

<div id="paymentBrick_container">
</div>

<div class="container mt-5" style="display: none;">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h3 class="mb-4">QRCode do Pix:</h3>
            <img id="pixImgQrCode" class="img-fluid mb-4" alt="QRCode Pix" style="max-height: 285px; display: inline;">
            <p class="mb-4">Se já efetuou o pagamento, já pode sair dessa página!</p>
            <h3 class="mb-4">Linha do Pix (Copia e Cola):</h3>
            <input type="text" class="form-control mb-3" name="codigo-pix" id="codigo-pix">
            <button id="copy-button" class="btn btn-info" data-clipboard-target="#codigo-pix">Copiar</button>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('input[name="_token"]').value;

    const mp = new MercadoPago("{{ env('PUBLIC_KEY_MP') }}", {
        locale: 'pt-BR'
    });

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

    const bricksBuilder = mp.bricks();
    const renderPaymentBrick = async (bricksBuilder) => {
        const settings = {
            initialization: {
                /*
                  "amount" é a quantia total a pagar por todos os meios de pagamento com exceção da Conta Mercado Pago e Parcelas sem cartão de crédito, que têm seus valores de processamento determinados no backend através do "preferenceId"
                */
                amount: {{ $dados['valor'] }},
                preferenceId: "0001",
                payer: {
                    firstName: "",
                    lastName: "",
                    email: "",
                },
            },
            customization: {
                visual: {
                    style: {
                        theme: "default",
                    },
                },
                paymentMethods: {
                    bankTransfer: "all",
                    atm: "all",
                    wallet_purchase: "all",
                    maxInstallments: 1
                },
            },
            callbacks: {
                onReady: () => {
                    /*
                     Callback chamado quando o Brick está pronto.
                     Aqui, você pode ocultar seu site, por exemplo.
                    */
                },
                onSubmit: ({
                    selectedPaymentMethod,
                    formData
                }) => {
                    // callback chamado quando há click no botão de envio de dados

                    return new Promise((resolve, reject) => {
                        fetch("/mercadopago/process_payment", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken,
                                },
                                body: JSON.stringify({
                                    formData,
                                    dados: {!! json_encode($dados) !!},
                                }),
                            })
                            .then((response) => response.json())
                            .then((response) => {
                                // receber o resultado do pagamento
                                $('#paymentBrick_container').hide();
                                $('.qrcode').css('display', 'block');

                                $('#pixImgQrCode').attr('src', 'data:image/png;base64,' +
                                    response.qr_code_base64)

                                $('#codigo-pix').val(response.qr_code)
                                resolve();
                            })
                            .catch((error) => {
                                // manejar a resposta de erro ao tentar criar um pagamento
                                alert('Erro ao criar o pagamento!');
                                reject();
                            });
                    });
                },
                onError: (error) => {
                    // callback chamado para todos os casos de erro do Brick
                    console.error(error);
                },
            },
        };
        window.paymentBrickController = await bricksBuilder.create(
            "payment",
            "paymentBrick_container",
            settings
        );
    };
    renderPaymentBrick(bricksBuilder);
</script>
