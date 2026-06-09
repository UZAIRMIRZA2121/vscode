@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
<style>
    .heading {
        text-align: center;
        color: #333;
        font-size: 40px
    }

    .paragraph {
        color: #666;
        margin-bottom: 20px;
        font-size: 24px
    }

    .list-item {
        color: #666;
        margin-bottom: 20px;
        font-size: 24px
    }

    .link {
        color: #007bff;
        text-decoration: none;
    }

    .link:hover {
        text-decoration: underline;
    }
</style>
<main>
    <section class="fleet-hero hero-section boat-section">
        <h1 class="hero-head fleet-head">Return Policy</h1>
    </section>
    <div class="container">
        <div class="wrapper">
            <div class="container mb-5">
                <h1 class="heading">About Msons Medicare</h1>
                <p class="paragraph">Welcome to Msons Medicare, your trusted partner in health and wellness. Established with a commitment to delivering premium healthcare solutions, Msons Medicare is dedicated to improving the quality of life for individuals and families across the globe.</p>
                <div class="section">
                    <h2 class="heading">Our Mission</h2>
                    <p class="paragraph">At Msons Medicare, our mission is to empower individuals to lead healthier, happier lives by providing access to high-quality healthcare products and services. We strive to be a beacon of wellness, offering comprehensive solutions that cater to the diverse needs of our customers.</p>
                </div>
                <div class="section">
                    <h2 class="heading">Our Vision</h2>
                    <p class="paragraph">Our vision at Msons Medicare is to create a world where healthcare is accessible to all, regardless of geographical location or socioeconomic status. We aspire to be at the forefront of healthcare innovation, driving positive change and making a meaningful impact on the lives of millions.</p>
                </div>
                <div class="section">
                    <h2 class="heading">Our Commitment to Quality</h2>
                    <p class="paragraph">Quality is the cornerstone of everything we do at Msons Medicare. We meticulously select our products from trusted manufacturers and suppliers, ensuring that each item meets the highest standards of safety, efficacy, and reliability. Your health and well-being are our top priorities, and we spare no effort in delivering excellence in every aspect of our operations.</p>
                </div>
                <div class="section">
                    <h2 class="heading">Why Choose Msons Medicare?</h2>
                    <ul>
                        <li class="list-item"><strong>Comprehensive Range:</strong> From medications and supplements to medical devices and personal care products, Msons Medicare offers a comprehensive range of healthcare solutions to address your every need.</li>
                        <li class="list-item"><strong>Affordable Excellence:</strong> We believe that quality healthcare should be accessible to all. That's why we strive to offer competitive prices without compromising on quality, making healthcare more affordable for everyone.</li>
                        <li class="list-item"><strong>Convenience Redefined:</strong> With our user-friendly online platform, shopping for healthcare products has never been easier. Enjoy the convenience of browsing, ordering, and receiving your products right at your doorstep, all from the comfort of your home.</li>
                        <li class="list-item"><strong>Customer-Centric Approach:</strong> At Msons Medicare, customer satisfaction is our ultimate priority. Our dedicated team is committed to providing exceptional service, personalized assistance, and timely support to ensure a seamless and satisfying experience for every customer.</li>
                    </ul>
                </div>

                <div class="section">
                    <h2 class="heading">Get in Touch</h2>
                    <p class="paragraph">We value your trust and confidence in Msons Medicare. Whether you have questions about our products, need assistance with your order, or simply want to share feedback, we're here to help. Feel free to <a href="/contact" class="link">contact us</a> or reach out to our friendly customer support team for prompt assistance. Thank you for choosing Msons Medicare for your healthcare needs.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>


<script>
    // Function to hide the alert after 5 seconds
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var statusAlert = document.getElementById('status-alert');
            var verificationAlert = document.getElementById('verification-alert');
            var alertAlert = document.getElementById('alert');

            if (statusAlert) {
                statusAlert.style.display = 'none';
            }
            if (verificationAlert) {
                verificationAlert.style.display = 'none';
            }
            if (alertAlert) {
                alertAlert.style.display = 'none';
            }
        }, 3000);
    });
</script>
@endsection