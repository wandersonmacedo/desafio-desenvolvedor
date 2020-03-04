@extends('layouts.app')

@section('content')
    <div class="container" id="containerPedido">
        <div class="card" style="display: none;position: absolute;right:0;">
            <div class="card-header">
                <p>Produtos adicionados ao pedido</p>
            </div>
            <div class="card-body">

            </div>
        </div>
        {{$order}}
    </div>
@endsection
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".table-responsive").on('click','#btnAddCart',function() {

            var row = $(this).closest("tr");    // Find the row
            var productId = row.find(".productId").text(); // Find the productID
            var productPrice = row.find(".productPrice").text(); // Find the productprice
            var nameProduct = row.find(".productName").text(); // Find the productname
            var productQuantity = row.find(".productQuantity").val(); // Find the orderQuantity


            if(!productQuantity || productQuantity == 0){
                alert("Quantidade pedida não pode ser 0 ou vazia");
                return false;
            }

            jQuery.ajax({
                url: "{{ route('pedidos.salvar') }}",
                method: 'post',
                data: {
                    productId: productId.trim(),
                    nameProduct: nameProduct.trim(),
                    productQuantity: productQuantity.trim()
                },
                success: function(result){
                    $(".card").show();
                    $('.card-body').append('<div class="alert alert-success" role="alert">\n' +
                        '  <p class="mb-0">' + nameProduct + '.</p>\n' +
                        '</div>');

                },
                failure: function (result) {

                    if(result.errors){
                        $("#containerPedido").html('<div class="alert alert-danger">'+result.erros+'</div>');
                    }
                }});
        });
    });
</script>