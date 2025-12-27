<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Wallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f2f2f2; margin: 0; display: flex; justify-content: center; align-items: center; }
        .wallet-container { background-color: #fff; width: 100%; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
        .wallet-header { background-color: #046c9f; padding: 20px 15px; display: flex; align-items: center; gap: 10px; }
        .wallet-header i { font-size: 26px; color: #fff; font-weight: bold; cursor: pointer; }
        .wallet-header h2 { color: #fff; font-size: 20px; margin: 0; }
        .wallet-balance { padding: 20px; text-align: center; }
        .wallet-balance p { font-size: 16px; margin: 5px 0; font-weight: bold; }
        .wallet-balance h1 { font-size: 32px; margin: 10px 0; color: #000; }
        .withdraw-line-input { display: flex; align-items: center; justify-content: center; border-bottom: 2px solid #ccc; width: 60%; margin: 10px auto; padding: 5px; }
        .rupee-symbol { font-size: 20px; color: #555; }
        .withdraw-input { border: none; outline: none; background: transparent; font-size: 20px; width: 100%; color: #000; text-align: left; }
        .payment-methods { padding: 20px; }
        .payment-methods h3 { font-size: 16px; margin-bottom: 10px; color: #555; }
        .method input[type="radio"] { width: 18px; height: 18px; accent-color: #046c9f; transform: scale(1.3); cursor: pointer; }
        .method { display: flex; align-items: center; justify-content: space-between; background: #fafafa; border: 1px solid #ddd; border-radius: 8px; padding: 10px; margin: 8px 0; }
        .method img { width: 40px; height: 40px; border-radius: 5px; object-fit: cover; border: 1px solid #ccc; }
        .method p { flex: 1; margin: 0 10px; font-weight: bold; }
        .link-btn { background-color: #fff; color: #046c9f; border: 1px solid #046c9f; padding: 6px 10px; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .link-btn:hover { background-color: #046c9f; color: #fff; }
        .withdraw-btn { background-color: #046c9f; color: white; border: none; padding: 13px; font-size: 18px; width: 80%; cursor: pointer; font-weight: bold; display: flex; justify-self: center; justify-content: center; border-radius: 10px; margin-bottom: 15px; }
        .withdraw-btn:hover { background-color: #0c9427; box-shadow: 0px 0px 1px 2px #04761b; }
        @media (max-width: 500px) { .wallet-header h2 { font-size: 18px; } .wallet-header i { font-size: 24px; } .withdraw-line-input { width: 80%; } .withdraw-btn { font-size: 16px; } .method p { font-size: 14px; } }
    </style>
</head>

<body>
    <div class="wallet-container">
        <header class="wallet-header">
            <i class="fa fa-arrow-left back-icon" onclick="window.history.back()"></i>
            <h2>Wallet</h2>
        </header>

        <div class="wallet-balance">
            <p>Balance</p>
            <h1>₹{{ number_format((float)($balance ?? 0), 2) }}</h1>
            <p>Withdrawal Amount</p>
            <div class="withdraw-line-input">
                <span class="rupee-symbol">₹</span>
                <input type="number" class="withdraw-input" value="0" min="0" />
            </div>
        </div>

        <div class="payment-methods">
            <h3>RECOMMENDED</h3>
            <div class="method">
                <img src="https://yt3.googleusercontent.com/nfovxGynnTWHMBFQfUjZzbFrViXNa9MYLZXuRFXhWGAfwWwIBsqV_4B5A_LGu0sZlMenuimmsQ=s900-c-k-c0x00ffffff-no-rj" alt="Paytm">
                <p>Paytm</p>
                <input type="radio" name="payment" checked>
            </div>

            <h3>OTHER METHODS</h3>
            <div class="method">
                <img src="https://freehindidesign.com/wp-content/uploads/2021/04/Jio-logo.jpg" alt="UPI">
                <p>UPI</p>
                <button class="link-btn" type="button">LINK NOW</button>
            </div>

            <div class="method">
                <img src="https://w7.pngwing.com/pngs/98/991/png-transparent-computer-icons-bank-icon-design-screenshot-bank-blue-angle-logo-thumbnail.png" alt="Bank Transfer">
                <p>Bank Transfer</p>
                <button class="link-btn" type="button">LINK NOW</button>
            </div>

            <div class="method">
                <img src="https://pbs.twimg.com/profile_images/1214220012979920898/N4tFtfjN_400x400.png" alt="Amazon Pay">
                <p>Amazon Pay</p>
                <button class="link-btn" type="button">LINK NOW</button>
            </div>
        </div>

        <button class="withdraw-btn" type="button">WITHDRAW NOW</button>
    </div>

    <script>
        const withdrawBtn = document.querySelector('.withdraw-btn');
        const inputField = document.querySelector('.withdraw-input');
        withdrawBtn.addEventListener('click', () => {
            const amount = inputField.value.trim();
            if (!amount || parseFloat(amount) <= 0) {
                alert('Please enter a valid amount to withdraw.');
                return;
            }
            alert("Sorry! You don't have sufficient balance to withdraw");
        });
        inputField.addEventListener('focus', function(){ if (this.value === '0') this.value = ''; });
        inputField.addEventListener('blur', function(){ if (this.value === '') this.value = '0'; });
    </script>
</body>

</html>