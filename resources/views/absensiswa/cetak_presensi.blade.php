<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kartu Ujian Siswa</title>

    <style>
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
            border-bottom: 1px solid #ddd;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            width: 20%;
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
    <!-- Print Button -->
    <button class="print-button" onclick="generatePDF()">Print as PDF</button>

    <!-- Isi Kartu Ujian -->
    <div id="cards-container">
        @foreach ($siswa as $data)
            <div class="card">
                <div class="header">
                    <img src="http://localhost/skripsi_umj/public/assets/img/logo_telkom.png" alt="Logo" />
                    <h3>SMP MUHAMMADIYAH 17 CIPUTAT</h3>
                </div>
                <table>

                    <tr>
                        <td>Nama :</td>
                        <td>{{ $data->nama }}</td>
                        <td>Kelas :</td>
                        <td>{{ $data->kelas }}</td>
                    </tr>

                </table>
                {{-- <p>Nama: {{ $data->nama }}</p>
                <p>Kelas: {{ $data->kelas }}</p>  --}}
                <div class="qr-code">
                    {!! QrCode::size(100)->generate('|'.$data->id.'|'.$data->nama.'|'.$data->kelas.'|') !!}
                </div>
            </div>
        @endforeach
    </div>

    <!-- JavaScript for Printing -->
    <script src="{{ asset('assets') }}/js/aplikasi.js"></script>
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
