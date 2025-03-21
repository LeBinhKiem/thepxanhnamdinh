<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    
<div class="container">
    
    <div class="row">
        <table class="table border-end table-cart border-start mt-3" hidden>
            <thead class="table-success">
            <tr>
                <th scope="col">Sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $jsonProduct = [];
            @endphp
            @foreach($carts as $cart)
                @php
                    $product = $cart->product;
                    if (!$product)
                    {
                        continue;
                    }

                    $totalItem = $product->price * (100 - $product->percent_sale) / 100;
                    $jsonProduct[] = [
                        "user_id" => get_user_id(),
                        "id" => $product->id,
                        "name" => $product->name,
                        "price" => $totalItem,
                        "image" => $product->image,
                        "amount" => $cart->amount,
                        ];
                    $totalItem = $totalItem * $cart->amount ;
                    $total += $totalItem;
                @endphp
                <tr>
                    <td>
                        <img src="{{ render_url_upload($product->image) }}"
                             style="width: 80px; height: 80px; object-fit: contain">
                        <a class="ms-2" href="
                    {{ route("get.sell.detail", $product->id) }}
                    ">{{ limit_text($product->name,30) }}</a>
                    </td>
                    <td>{{ number_format($product->price * (100 - $product->percent_sale) / 100) }} VNĐ</td>
                    <td class="text-center">
                        {{ $cart->amount }}
                    </td>
                    <td>{{ number_format($totalItem)  }} VNĐ</td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td style="background-color: #c4f1de" colspan="3">Tổng tiền:</td>
                <td style="background-color: #c4f1de">{{ number_format($total) }} VNĐ</td>
            </tr>
            </tbody>
        </table>
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                        <h3 class="panel-title text-center" >Thanh toán visa</h3>
                </div>
                <div class="panel-body">
    
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post',$total) }}" 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                        @csrf
                        

                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group {{ has_error($errors, "name") }}">
                                        <label for="" class="form-label">Họ và tên</label>
                                        <input type="text" name="name" value="{{ old("name", $user->full_name ?? "") }}"
                                               class="form-control" placeholder="Họ tên">
                                        {!! get_error($errors, "name") !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 form-group {{ has_error($errors, "number_phone") }}">
                                        <label for="" class="form-label">Số điện thoại</label>
                                        <input type="text" name="number_phone"
                                               value="{{ old_input("number_phone", $user) }}" class="form-control"
                                               placeholder="Số điện thoại">
                                        {!! get_error($errors, "number_phone") !!}
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group {{ has_error($errors, "address") }}">
                                    <label for="" class="form-label">Địa chỉ</label></label>
                                    <textarea class="form-control" name="address" id="" cols="30" rows="5"
                                        placeholder="Nhập địa chỉ nhận hàng">{{ old("address", $user->short_desc ?? "") }}</textarea>
                                    {!! get_error($errors, "address") !!}
                                </div>
                                <input type="hidden" name="payment" value="Chuyển khoản">
                                <input type="hidden" name="status" value="1">
                            </div>




                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-12">
                                <input type="hidden" name="total" value="{{ $total }}">
                                <input type="hidden" name="product_json" value="{{ json_encode($jsonProduct) }}">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Thanh toán {{ number_format($total) }} VNĐ</button>
                            </div>
                        </div>
                            
                    </form>
                </div>
            </div>        
        </div>
    </div>
        
</div>
    
</body>
    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
<script type="text/javascript">
  
$(function() {
  
    /*------------------------------------------
    --------------------------------------------
    Stripe Payment Code
    --------------------------------------------
    --------------------------------------------*/
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
</html>