<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kartu Presensi Siswa</title>
    <script src="{{ asset('assets') }}/js/jspdf.umd.min.js"></script>

    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-gap: 20px;
        }

        /* Define A4 size */
        @page {
            size: A4;
            margin: 0;
        }

        /* Set layout for printing */
        body {

            font-family: Arial, sans-serif;
            background-color: #666464;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            height: 390px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .card h2 {
            margin: 0;
        }

        .card p {
            margin: 5px 0;
        }

        .qr-code {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header {
            background: #007bff;
            color: #fff;
            margin-left: -20px;
            margin-right: -20px;

            border-bottom: 1px solid #ddd;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 15%;
            margin-right: 10px;
        }

        /* Floating Print Button */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Adjust for print */
        @media print {
            body {
                padding: 0;
            }

            .card {
                page-break-inside: avoid;
            }

            .print-button {
                display: none;
                /* Hide print button in print mode */
            }
        }
    </style>
</head>

<body>
    <button class="print-button" onclick="generatePDF()">Print as PDF</button>

    <div id="cards-container">
        @foreach ($siswa as $data)
            <div class="card">
                <div class="header">
                    <img src="{{ asset('assets/img/logo_telkom.png') }}" class="img-responsive" />

                    <h3>SMP MUHAMMADIYAH 17 CIPUTAT</h3>
                </div>
                <table style="margin-top: -80px">
                    <tr>
                        <td>Nama :</td>
                        <td>{{ $data->nama }}</td>

                    </tr>
                    <tr>
                        <td>Kelas :</td>
                        <td>{{ $data->kelas }}</td>
                    </tr>
                </table>
                <div class="qr-code">
                    {!! QrCode::size(100)->generate('|' . $data->id . '|' . $data->nama . '|' . $data->kelas . '|') !!}
                </div>
            </div>
        @endforeach
    </div>
    {{-- |100|LUTFIA SAFANA|9| idsiswanya --}}
    <script>
        function generatePDF() {
            const doc = new jsPDF();
            const cards = document.querySelectorAll('.card');
            let yPos = 10;

            cards.forEach(card => {
                doc.text(15, yPos, card.innerText);
                yPos += 60; // Adjust the value to separate the cards vertically
                if (yPos >= 270) {
                    doc.addPage(); // Create a new page if the content exceeds the page height
                    yPos = 10;
                }
            });

            doc.save('kartu_ujian_siswa.pdf');
        }
    </script>
</body>

</html>
