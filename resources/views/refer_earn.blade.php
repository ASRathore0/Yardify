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
    <title>Refer & Earn</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: Arial, sans-serif; }
        body { display:flex; justify-content:center; align-items:center; min-height:100vh; background:#fff; }
        .container { width:100%; max-width:400px; background:#fff; border-radius:12px; padding:20px; text-align:center; }
        .gift-box { display:flex; justify-content:center; width:50%; margin:auto; }
        h2 { color:#000; font-size:18px; }
        .invite-btn { background:#000; color:#fff; padding:10px 15px; border:none; border-radius:20px; cursor:pointer; margin-top:10px; }
        .social-icons { display:flex; justify-content:space-between; margin:20px 0; gap:10px; text-align:center; align-items:center; }
        .social-icons div { flex:1; padding:10px; height:50px; width:40px; border-radius:10%; text-align:center; cursor:pointer; }
        .whatsapp { background:#25D366; color:#fff; font-size:13px; }
        .sms { background:#FFC107; color:#000; font-size:13px; }
        .qr { background:#007BFF; color:#fff; font-size:13px; }
        .referral-code { background:#f0f0f0; padding:10px; border-radius:10px; display:flex; justify-content:space-between; align-items:center; }
        .referral-code span { font-weight:bold; }
        .referral-code i { color:#23a3df; font-size:large; }
        .terms { text-align:left; margin-top:20px; }
        .terms h3 { color:#046c9f; font-size:16px; }
        .terms p { font-size:14px; margin:10px 0; color:#333; }
        .more { 
            background: #6C757D; 
            color: white; 
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Refer friends to BookingYard.in &<br>get upto <strong>₹100 Cashback</strong> on each referral</h3>
        <img src="https://media.istockphoto.com/id/537644859/vector/vector-box-with-blue-ribbon-and-bow-isolated-on-background.jpg?s=170667a&w=0&k=20&c=tDuG2GiM95KuHhgp-T6rDXFMwUCsN2GJCpb7HXu3V-w=" alt="Gift Box" class="gift-box">

        <button class="invite-btn" type="button">Share your invite link</button>
        <div class="social-icons">
            <div class="whatsapp"><i class="fab fa-whatsapp"></i> Whatsapp</div>
            <div class="sms"><i class="fas fa-comment-alt"></i> Message</div>
            <div class="qr"><i class="fas fa-qrcode"></i> QRCode</div>
            <div class="more"><i class="fas fa-ellipsis-h"></i> More</div>
        </div>

        <div class="referral-code">
             <p>Share your referral code: </p>
            <span id="referralCode">{{ $referralCode }}</span>
            <button type="button" onclick="copyReferralCode()"><i class="fa fa-copy"></i></button>
        </div>

        <div class="terms">
            <h3>What is the Refer & Earn program on BookingYard.in?</h3>
            <p>It's a referral program where you earn rewards for inviting your family and friends to expand their business by connecting with customers looking for top-quality services.</p>
            <h3>What is the Reward for You?</h3>
            <p><strong>New-to-BookingYard.in</strong></p>
            <p>Get upto ₹100 cashback when your friend creates their account successfully.</p>
            <p>The Refer and Earn program only applies to vendor registrations, not customer registrations.</p>
            <p><strong>Note: </strong>You will not be eligible for cashback if:</p>
            <p>a. The referred user has already been referred by someone else before.</p>
            <p>b. You or the referred user use fake or duplicate accounts to complete the transaction.</p>
            <p>c. The payment is not completed or is later disputed or refunded.</p>
            <p>d. You refer yourself using different accounts, devices, or email addresses.</p>
        </div>
    </div>

    <script>
        const referralCode = @json($referralCode);
        const shareText = `*Hi! I'm inviting you to join BookingYard!*\n\nBookingYard is the easiest way to connect with top service providers and expand your business.\n\nUse my referral code: ${referralCode} or click the link below to sign up and start booking hassle-free.\n\n💰 Win up to ₹50 Cashback on your first successful registration if you're new to BookingYard!\n\nJoin now and grow with India's trusted booking platform:`;
        const shareUrl = 'https://bookingyard.in/assets/vender.html';

        function copyReferralCode(){
            navigator.clipboard.writeText(referralCode).then(()=>alert('Referral Code Copied: ' + referralCode));
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
</body>
</html>