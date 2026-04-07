<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Join BookingYard & Earn Cashback!" />
    <meta property="og:description" content="Sign up using my referral code and win up to ₹50 cashback!" />
    <meta property="og:image" content="{{ asset('image/bookingyard.jpg') }}" />
    <meta property="og:url" content="{{ url('/refer-earn') }}" />
    <meta property="og:type" content="website" />
    <title>Refer & Earn | BookingYard</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --dark-color: #212529;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        
        body { background-color: #f4f7f6; color: var(--dark-color); line-height: 1.6; }

        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: calc(100vh - 100px);
        }

        .refer-card {
            width: 100%;
            max-width: 450px;
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .hero-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .hero-title span { color: var(--primary-color); }

        .gift-container {
            background: #eef7ff;
            border-radius: 50%;
            width: 140px;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .gift-box-img {
            width: 100px;
            height: auto;
            object-fit: contain;
        }

        .invite-btn {
            background: var(--dark-color);
            color: var(--white);
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            margin-bottom: 25px;
        }

        .invite-btn:active { transform: scale(0.98); }

        .social-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 30px;
        }

        .social-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: transform 0.2s;
        }

        .social-item span { font-size: 11px; font-weight: 600; color: var(--secondary-color); }

        .whatsapp .social-icon { background: #25D366; color: white; }
        .sms .social-icon { background: #FFC107; color: black; }
        .qr .social-icon { background: #007BFF; color: white; }
        .more .social-icon { background: #f0f0f0; color: #333; }

        .social-item:hover .social-icon { transform: translateY(-3px); }

        .referral-box {
            background: var(--light-bg);
            border: 2px dashed #cbd5e0;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .referral-label { font-size: 13px; color: var(--secondary-color); text-align: left; }
        .referral-code-text { font-size: 18px; font-weight: 800; color: var(--dark-color); letter-spacing: 1px; }

        .copy-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            padding: 5px 10px;
            font-size: 18px;
        }

        .terms-section {
            text-align: left;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .terms-section h3 {
            font-size: 15px;
            color: var(--dark-color);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .terms-section h3::before {
            content: '';
            width: 4px;
            height: 15px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .terms-section p {
            font-size: 13px;
            color: #555;
            margin-bottom: 10px;
            padding-left: 12px;
            position: relative;
        }

        .note {
            background: #fff8e1;
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .refer-card { padding: 20px; border-radius: 0; box-shadow: none; padding-top: 60px;}
            body { background: white; }
        }
    </style>
</head>
<body>
    @include('partials.header')
    @include('partials.sidebar')
    @include('partials.footer-modern')

    <div class="main-wrapper">
        <div class="refer-card">
            <h3 class="hero-title">Refer friends to BookingYard    &<br>Get upto <span>₹100 Cashback</span></h3>
            
            <div class="gift-container">
                <img src="https://media.istockphoto.com/id/537644859/vector/vector-box-with-blue-ribbon-and-bow-isolated-on-background.jpg?s=170667a&w=0&k=20&c=tDuG2GiM95KuHhgp-T6rDXFMwUCsN2GJCpb7HXu3V-w=" alt="Gift Box" class="gift-box-img">
            </div>

            <button class="invite-btn" type="button">Share invite link</button>

            <div class="social-grid">
                <div class="social-item whatsapp">
                    <div class="social-icon"><i class="fab fa-whatsapp"></i></div>
                    <span>WhatsApp</span>
                </div>
                <div class="social-item sms">
                    <div class="social-icon"><i class="fas fa-comment-alt"></i></div>
                    <span>Message</span>
                </div>
                <div class="social-item qr">
                    <div class="social-icon"><i class="fas fa-qrcode"></i></div>
                    <span>QR Code</span>
                </div>
                <div class="social-item more">
                    <div class="social-icon"><i class="fas fa-ellipsis-h"></i></div>
                    <span>More</span>
                </div>
            </div>

            <div class="referral-box">
                <div style="text-align: left;">
                    <p class="referral-label">Your Referral Code</p>
                    <span class="referral-code-text" id="referralCode">{{ $referralCode }}</span>
                </div>
                <button class="copy-btn" type="button" onclick="copyReferralCode()" title="Copy Code">
                    <i class="fa-regular fa-copy"></i>
                </button>
            </div>

            <div class="terms-section">
                <h3>How it works?</h3>
                <p>Earn rewards for inviting friends to expand their business on India's trusted booking platform.</p>
                
                <h3>The Reward</h3>
                <p>Get <strong>₹100 cashback</strong> when your friend creates a vendor account successfully.</p>
                
                <div class="note">
                    <p style="margin-bottom: 0;"><strong>Note:</strong> Reward applies to Vendor registrations only. Fake or duplicate accounts will be disqualified.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Keep your existing JS Logic exactly as is
        const referralCode = @json($referralCode);
        const shareText = `*Hi! I'm inviting you to join BookingYard!*\n\nBookingYard is the easiest way to connect with top service providers and expand your business.\n\nUse my referral code: ${referralCode} or click the link below to sign up and start booking hassle-free.\n\n💰 Win up to ₹50 Cashback on your first successful registration if you're new to BookingYard!\n\nJoin now and grow with India's trusted booking platform:`;
        const shareUrl = 'https://bookingyard.in/assets/vender.html';

        function copyReferralCode(){
            navigator.clipboard.writeText(referralCode).then(() => {
                const btn = document.querySelector('.copy-btn i');
                btn.classList.replace('fa-regular', 'fa-solid');
                btn.classList.replace('fa-copy', 'fa-check');
                setTimeout(() => {
                    btn.classList.replace('fa-solid', 'fa-regular');
                    btn.classList.replace('fa-check', 'fa-copy');
                }, 2000);
            });
        }

        document.querySelector('.invite-btn').addEventListener('click', function(){
            const data = { title: 'Join BookingYard & Earn Cashback!', text: shareText + '\n' + shareUrl, url: shareUrl };
            if (navigator.share) { navigator.share(data).catch(console.error); }
            else { alert('Sharing not supported on this device.'); }
        });

        document.querySelector('.whatsapp').addEventListener('click', function(){
            const message = shareText + '\n' + shareUrl;
            const url = `https://wa.me/?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        });

        document.querySelector('.sms').addEventListener('click', function(){
            const message = shareText + '\n' + shareUrl;
            const url = `sms:?&body=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        });

        document.querySelector('.more').addEventListener('click', function(){
            const data = { title: 'Join BookingYard & Earn Cashback!', text: shareText + '\n' + shareUrl, url: shareUrl };
            if (navigator.share) { navigator.share(data).catch(console.error); }
            else { alert('Sharing not supported on this device.'); }
        });
    </script>

    @include('partials.footer-mobile')
    <script src="js/script.js"></script>
    <script src="js/script1.js"></script>
</body>
</html>