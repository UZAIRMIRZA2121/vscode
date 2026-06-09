     <!-- footer -->
     <footer class="footer-starter ">
        <div class="container footer-section">
            <div class="row footer-flex">
              
                <div class="footer-col  col-lg-3 col-md-6 col-sm-12">
                    <ul>
                        <strong>About</strong>
                        <li><a href="{{ route('contactus') }}">Contact </a></li>
                        <li><a href="{{ route('aboutus') }}">About Us</a></li>
                    </ul>
                </div>
                <div class="footer-col  col-lg-3 col-md-6 col-sm-12">
                    <ul>
                        <strong>Company</strong>
                        <li><a href="{{ route('nurse') }}">Nurse</a> </li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('contactus') }}">Contact</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
                <div class="footer-col  col-lg-3 col-md-6 col-sm-12">
                    <ul>
                        <strong>Policy</strong>
                        <li><a href="{{ route('returnpolicy') }}">Return Policy</a> </li>
                        <li><a href="{{ route('termcondition') }}">Terms & Condition</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy</a></li>
                        {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                    </ul>
                </div>
                <!--<div class="footer-col col-lg-2 col-md-6 col-sm-12">-->
                    <!--<div class="row">-->
                    <!--    <strong>Social Links</strong>-->
                    <!--    <div class="col-12">-->
                    <!--        <a href="#"><ion-icon class="icon text-light " name="logo-facebook">facebook</ion-icon></a>-->
                    <!--        facebook-->
                    <!--    </div>-->
                    <!--    <div class="col-12">-->
                    <!--        <a href="#"><ion-icon class="icon text-light" name="logo-instagram"></ion-icon></a>-->
                    <!--        instagram-->
                    <!--    </div>-->
                    <!--    <div class="col-12">-->
                    <!--        <a href="#"><ion-icon class="icon text-light" name="logo-whatsapp"></ion-icon></a>-->
                    <!--        whatsapp-->
                    <!--    </div>-->
                    <!--    <div class="col-12">-->
                    <!--        <a href="#"><ion-icon class="icon text-light" name="logo-linkedin"></ion-icon></a>-->
                    <!--        linkedin-->
                    <!--    </div>-->
                    <!--    <div class="col-12">-->
                    <!--        <a href="#"><ion-icon class="icon text-light" name="logo-pinterest"></ion-icon></a>-->
                    <!--        pinterest-->
                    <!--    </div>-->
                    <!--</div>-->
                <!--</div>-->
                
                <div class="footer-col  col-lg-3 col-md-6 col-sm-12">
                    <ul>
                        <strong>Address</strong>
                        <div class="footer-address">
                            <div class="d-flex gap-2 align-items-center">
                                <span><ion-icon class="icon" name="pin"></span>
                                <p class="footer-text ">House # 457-K, Street # 58, Sector I-8/3,Islamabad,Pakistan</p>
                            </div>
                            <div class="d-flex gap-2 align-items-start ">
                                <span><ion-icon class="icon" name="mail"></span>
                                <a href="" class=" ">contact@MsOns.pk</a>
                            </div>
                            <div class="d-flex gap-2 align-items-start ">
                                <span><ion-icon class="icon" name="call"></span>
                                <a class=" " href="tel: +923177096898">Phone: +92333333333</a>
                            </div>
                        </div>



                    </ul>
                </div>
            </div>
            <div class="footer-content d-flex justify-content-between align-items-center">
                <p class="text-center py-3">© 2025 MsOns Enterprises. All Rights Reserved.</p>
                <div class="payment-methods">
                    <img src="{{ asset('frontend-asset/img/cod.png') }}" alt="Cash on Delivery">
                    <img src="{{ asset('frontend-asset/img/stripe.png') }}" alt="Stripe">
                </div>
            </div>
        </div>
    </footer>


    <script src="https://use.fontawesome.com/1744f3f671.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        
        $(document).ready(function(){
            var currentIndex = 0;
            var itemWidth = $('.slider-item').outerWidth(true);
            var itemsCount = $('.slider-item').length;
            var visibleItems = 4;
            var itemsPerSlide = Math.min(itemsCount, visibleItems);
    
            $('#nextBtn').click(function(){
                if (currentIndex < itemsCount - itemsPerSlide) {
                    currentIndex++;
                    updateSliderPosition();
                }
            });
    
            $('#prevBtn').click(function(){
                if (currentIndex > 0) {
                    currentIndex--;
                    updateSliderPosition();
                }
            });
    
            function updateSliderPosition() {
                var translateValue = -1 * currentIndex * itemWidth;
                $('.slider-inner').css({
                    'transform': 'translateX(' + translateValue + 'px)'
                });
            }
    
            function autoSlide() {
                setInterval(function(){
                    if (currentIndex < itemsCount - itemsPerSlide) {
                        currentIndex++;
                        updateSliderPosition();
                    } else {
                        currentIndex = 0;
                        updateSliderPosition();
                    }
                }, 3000);
            }
    
            autoSlide();
        });
    </script>




<script>
    // Function to hide the message after 3 seconds
    function hideMessage(messageId) {
        var message = document.getElementById(messageId);
        if (message) {
            setTimeout(function() {
                message.style.display = 'none';
            }, 3000);
        }
    }

    // Call hideMessage function for success and error messages
    hideMessage('successMessage');
    hideMessage('errorMessage');
</script>
</body>

</html>