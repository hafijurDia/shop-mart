<div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                    <div class="newsletter_title_container">
                        <div class="newsletter_icon"><img src="{{asset('public/frontend')}}/images/send.png" alt=""></div>
                        <div class="newsletter_title">Sign up for Newsletter</div>
                        <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                    </div>
                    <div class="newsletter_content clearfix">
                        <form action="{{route('store.newsletter')}}" method="post" class="newsletter_form" id="newsletter_form">
                            @csrf
                            <input type="email" name="email" class="newsletter_input" required="required" placeholder="Enter your email address">
                            <button class="newsletter_button" type="submit">Subscribe</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    //store coupon ajax call
    $('#newsletter_form').submit(function(e){
      e.preventDefault();
      var url = $(this).attr('action');
      var request =$(this).serialize();
      $.ajax({
        url:url,
        type:'post',
        async:false,
        data:request,
        success:function(data){
          toastr.success(data);
          $('#newsletter_form')[0].reset();
        }
      });
    });
  </script>   