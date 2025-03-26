<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Grafik Pembelian</title>
    
</head>

<body>
    <div class="container">
        <main class="container-main">
            <h1>Dashboard - Grafik Pembelian</h1>

            <!-- Card for Purchase Graph -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Grafik Pembelian Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="canvas-container">
                        <canvas id="pembelianChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script to Generate Graph -->
    <script>
        const pembelianData = {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
            datasets: [{
                label: 'Total Pembelian (Rp)',
                data: [100000, 150000, 120000, 130000, 140000, 160000],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        const config = {
            type: 'line',
            data: pembelianData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return 'Rp ' + tooltipItem.raw.toLocaleString(); // Format Rupiah
                            }
                        }
                    }
                }
            }
        };

        // Membuat Grafik
        const pembelianChart = new Chart(
            document.getElementById('pembelianChart'),
            config
        );
    </script>
    <style>
      
      /* Penataan body agar alur scroll bekerja */
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        /* Penataan utama area konten */
        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        /* Penataan untuk card yang berisi grafik */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 1000px; /* Membatasi lebar card */
            padding: 20px;
        }

        .card-header {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .card-body {
            padding: 0;
            margin: 0;
        }

        .canvas-container {
            height: 400px;
            width: 100%;
            overflow-x: auto;
        }

        /* Membuat card dan grafik lebih rapat ke kiri */
        .container-main {
            margin-left: 10px;
            margin-top: 20px;
            width: 100%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        
    </style>
</body>

</html>
