@extends('layouts.guest-master')

@section('content')
<style>
    .main-form{
        padding-top: 5rem;
        padding-bottom: 5rem;
    }
    </style>
<div class="container-fluid main-form">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            
            <!-- Success Card -->
            <div class="card shadow-lg border-0 overflow-hidden">
                
                <!-- Celebration Header -->
                <div class="card-header bg-gradient text-white text-center py-5 position-relative" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    
                    <!-- Animated Confetti Background -->
                    <div class="position-absolute w-100 h-100 top-0 start-0" style="opacity: 0.1;">
                        <div class="confetti">🎉 🎊 ✨ 🌟 🎈 🎉 🎊 ✨ 🌟 🎈 🎉 🎊 ✨ 🌟 🎈 🎉 🎊 ✨ 🌟 🎈</div>
                    </div>
                    
                    <!-- Success Icon -->
                    <div class="mb-4 position-relative">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-lg animate-bounce" 
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    
                    <h1 class="display-5 fw-bold mb-2">🎉 Registration Successful! 🎉</h1>
                    <p class="lead mb-0">Your business journey with GME begins now!</p>
                </div>

                <div class="card-body p-5">
                    
                    <!-- Thank You Message -->
                    <div class="text-center mb-5">
                        <h3 class="fw-bold text-primary mb-3">
                            <i class="fas fa-heart text-danger me-2"></i>
                            Thank You for Joining GME!
                        </h3>
                        <p class="text-muted fs-5">
                            Your application has been submitted successfully and is now pending review by our team.
                        </p>
                    </div>

                    <!-- What's Next Section -->
                    <div class="alert alert-info border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px;">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-primary">What Happens Next?</h5>
                        </div>
                        
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3 d-flex align-items-start">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div>
                                    <strong class="text-dark">Review Process:</strong>
                                    <span class="text-muted">Our team will carefully review your application within 3-5 business days</span>
                                </div>
                            </li>
                            
                            <li class="mb-3 d-flex align-items-start">
                                <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <strong class="text-dark">Email Notification:</strong>
                                    <span class="text-muted">You'll receive an email once your profile is approved</span>
                                </div>
                            </li>
                            
                            <li class="mb-3 d-flex align-items-start">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <strong class="text-dark">Additional Information:</strong>
                                    <span class="text-muted">We may contact you if we need any clarification</span>
                                </div>
                            </li>
                            
                            <li class="d-flex align-items-start">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                     style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <strong class="text-dark">Go Live:</strong>
                                    <span class="text-muted">Once approved, your business profile will be published on GME</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Benefits Section -->
                    <div class="row g-3 mb-5">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm text-center p-4" style="background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);">
                                <div class="mb-3">
                                    <i class="fas fa-users fa-3x text-white"></i>
                                </div>
                                <h6 class="fw-bold text-white">Connect with Community</h6>
                                <p class="small text-white mb-0">Join a network of ethical businesses</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm text-center p-4" style="background: linear-gradient(135deg, #81ecec 0%, #00b894 100%);">
                                <div class="mb-3">
                                    <i class="fas fa-handshake fa-3x text-white"></i>
                                </div>
                                <h6 class="fw-bold text-white">Collaboration Opportunities</h6>
                                <p class="small text-white mb-0">Find partners and grow together</p>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm text-center p-4" style="background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);">
                                <div class="mb-3">
                                    <i class="fas fa-chart-line fa-3x text-white"></i>
                                </div>
                                <h6 class="fw-bold text-white">Business Growth</h6>
                                <p class="small text-white mb-0">Access resources and support</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <a href="{{ url('/') }}" 
                               class="btn btn-primary btn-lg w-100 shadow-sm">
                                <i class="fas fa-home me-2"></i>
                                Return to Dashboard
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('gme.business.register') }}" 
                               class="btn btn-outline-secondary btn-lg w-100">
                                <i class="fas fa-plus-circle me-2"></i>
                                Register Another Business
                            </a>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="text-center pt-4 border-top">
                        <p class="text-muted mb-2">
                            <i class="fas fa-question-circle me-2"></i>
                            Have questions or need assistance?
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="mailto:support@gme.com" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-envelope me-1"></i>
                                support@gme.com
                            </a>
                            <a href="https://wa.me/1234567890" class="btn btn-sm btn-outline-success">
                                <i class="fab fa-whatsapp me-1"></i>
                                WhatsApp Support
                            </a>
                            <a href="tel:+1234567890" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-phone me-1"></i>
                                Call Us
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <canvas id="confetti-canvas" style="position: fixed; top:0; left:0; width:100%; height:100%; pointer-events:none; z-index: 9999;"></canvas>

</div>

<!-- Custom CSS for Animations -->
<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

@keyframes confetti {
    0% { transform: translateX(0); }
    100% { transform: translateX(100%); }
}

.confetti {
    display: flex;
    gap: 2rem;
    font-size: 2rem;
    animation: confetti 20s linear infinite;
    white-space: nowrap;
}

/* Hover Effects */
.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Gradient Background */
.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Card Shadows */
.shadow-lg {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>

<!-- Auto-dismiss success message after 5 seconds -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Add confetti effect using canvas or library
    console.log('🎉 Registration successful! Welcome to GME!');
    
    // Optional: Play success sound
    // const audio = new Audio('/sounds/success.mp3');
    // audio.play();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const canvas = document.getElementById('confetti-canvas');
    const ctx = canvas.getContext('2d');

    // Make canvas full screen
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Confetti particles
    const confettiCount = 150; // Increase for bigger blast
    const confetti = [];

    for (let i = 0; i < confettiCount; i++) {
        confetti.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height - canvas.height,
            r: Math.random() * 6 + 4, // radius
            d: Math.random() * confettiCount,
            color: `hsl(${Math.random() * 360}, 100%, 50%)`,
            tilt: Math.random() * 10 - 10,
            tiltAngleIncremental: Math.random() * 0.07 + 0.05,
            tiltAngle: 0
        });
    }

    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        for (let i = 0; i < confettiCount; i++) {
            const c = confetti[i];
            ctx.beginPath();
            ctx.lineWidth = c.r / 2;
            ctx.strokeStyle = c.color;
            ctx.moveTo(c.x + c.tilt + c.r / 4, c.y);
            ctx.lineTo(c.x + c.tilt, c.y + c.tilt + c.r / 4);
            ctx.stroke();
        }
        update();
    }

    function update() {
        for (let i = 0; i < confettiCount; i++) {
            const c = confetti[i];
            c.tiltAngle += c.tiltAngleIncremental;
            c.y += (Math.cos(c.d) + 3 + c.r / 2) / 2;
            c.x += Math.sin(c.d);
            c.tilt = Math.sin(c.tiltAngle - i / 3) * 15;

            if (c.y > canvas.height) {
                c.x = Math.random() * canvas.width;
                c.y = -20;
            }
        }
    }

    // Animate
    function animate() {
        draw();
        requestAnimationFrame(animate);
    }

    animate();

    // Optional: Remove confetti after 10 seconds
    setTimeout(() => {
        canvas.remove();
    }, 10000);

});
</script>

@endsection