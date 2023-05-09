<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #reader {
        width: 600px;
    }
    #result {
        text-align: center;
        font-size: 1.5rem;
    }
</style>
    
<main>
    <div id="reader"></div>
    <div id="result"></div>
</main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    const scanner = new Html5QrcodeScanner('reader', { 
        qrbox: {
            width: 250,
            height: 250,
        },
        fps: 30,
    });

    scanner.render(success, error);

    function success(result) {
    if (/^\d{10}$/.test(result)) {
        const url = `sendCrypto/sendNumberScan.php?toAddress=${result}`;
        window.location.href = url;
    } else if (/^[a-zA-Z0-9]{42}$/.test(result)) {
        const url = `sendCrypto/sendAddressScan.php?toAddress=${result}`;
        window.location.href = url;
    } else {
        alert('Invalid recipient mobile number or Ethereum address. Please try again.');
        scanner.restart();
    }
}



    function error(err) {
        console.error(err);
    }
</script>