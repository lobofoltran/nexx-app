<x-guest-layout>
    @livewire('costumer-table')

    {{-- <div style="max-width: 500px; max-height: 800px;">
        <div id="reader"></div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script type="module">
        function onScanSuccess(decodedText, decodedResult) {
            alert(decodedText);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 200, height: 250} }, false); 
        html5QrcodeScanner.render(onScanSuccess);
    </script> --}}
</x-guest-layout>
