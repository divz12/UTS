<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Gaji Tim Software</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 6px;
            text-align: left;
            font-weight: bold;
        }
        input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        input[type="submit"] {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
        }
        input[type="submit"]:hover {
            background-color: #0b5ed7;
        }
        .hasil {
            background-color: #e9f0fa;
            border-radius: 6px;
            padding: 15px;
            margin-top: 15px;
            text-align: left;
            font-size: 15px;
        }
        .hasil p {
            margin: 5px 0;
        }
    </style>
</head>
<body> 
<div class="container">
    <h2>Perhitungan Gaji Tim Software</h2>

    <form action="" method="post">
        <label for="anggota">Nama Anggota</label>
        <select name="anggota" id="anggota" required>
            <option value="">-- Pilih Anggota --</option>
            <?php
            $anggota = ["Diva", "Haikal", "Reza", "Zahra", "Sipa"];
            foreach ($anggota as $nama) {
                echo "<option value='$nama'>$nama</option>";
            }
            ?>
        </select>

        <label for="posisi">Posisi</label>
        <select name="posisi" id="posisi" required>
            <option value="">-- Pilih Posisi --</option>
            <option value="Lead Developer">Lead Developer</option>
            <option value="QA Engineer">QA Engineer</option>
            <option value="DevOps Engineer">DevOps Engineer</option>
            <option value="Backend Dev">Backend Dev</option>
            <option value="Frontend Dev">Frontend Dev</option>
        </select>

        <label for="jamKerja">Jam Kerja (per bulan)</label>
        <input type="number" id="jamKerja" name="jamKerja" min="0" required>

        <label for="nilaiProject">Nilai Harga Project (Rp)</label>
        <input type="number" id="nilaiProject" name="nilaiProject" min="0" required>

        <input type="submit" name="hitung" value="Hitung Gaji">
    </form>

    <?php
    function UpahPerjam($posisi) {
        $upah = [
            "Lead Developer" => 450000,
            "QA Engineer" => 250000,
            "DevOps Engineer" => 350000,
            "Backend Dev" => 300000,
            "Frontend Dev" => 300000
        ];
        return $upah[$posisi];
    }

    function PersentaseLembur($posisi) {
        $persen = [
            "Lead Developer" => 0.18,
            "QA Engineer" => 0.12,
            "DevOps Engineer" => 0.10,
            "Backend Dev" => 0.15,
            "Frontend Dev" => 0.15
        ];
        return $persen[$posisi];
    }

    function PersentaseFee($posisi) {
        $persen = [
            "Lead Developer" => 0.05,
            "QA Engineer" => 0.01,
            "DevOps Engineer" => 0.025,
            "Backend Dev" => 0.03,
            "Frontend Dev" => 0.03
        ];
        return $persen[$posisi];
    }

    function hitungGaji($posisi, $jamKerja, $nilaiProject) {
    $upahPerJam = UpahPerjam($posisi);
    $jamNormal = 160;

        if ($jamKerja <= $jamNormal) {
            $upahKerja = $upahPerJam * $jamKerja;
            $upahLembur = 0;
        } else {
            $jamLembur = $jamKerja - $jamNormal;
            $upahKerja = $upahPerJam * $jamNormal;
            $upahLembur = $upahPerJam * PersentaseLembur($posisi) * $jamLembur;
        }

        $feeProject = $nilaiProject * PersentaseFee($posisi);
        $total = $upahKerja + $upahLembur + $feeProject;

        return [
            "upahKerja" => $upahKerja,
            "upahLembur" => $upahLembur,
            "feeProject" => $feeProject,
            "total" => $total
        ];
    }

    if (isset($_POST['hitung'])) {
        $anggota = $_POST['anggota'];
        $posisi = $_POST['posisi'];
        $jamKerja = $_POST['jamKerja'];
        $nilaiProject = $_POST['nilaiProject'];

        $gaji = hitungGaji($posisi, $jamKerja, $nilaiProject);

        echo "<div class='hasil'>";
        echo "<strong>Hasil Perhitungan Gaji untuk $anggota ($posisi):</strong><br>";
        echo "<p>Upah Kerja: Rp " . number_format($gaji['upahKerja'], 0, ',', '.') . "</p>";
        echo "<p>Upah Lembur: Rp " . number_format($gaji['upahLembur'], 0, ',', '.') . "</p>";
        echo "<p>Fee Project: Rp " . number_format($gaji['feeProject'], 0, ',', '.') . "</p>";
        echo "<hr>";
        echo "<p><strong>Total Gaji Diterima: Rp " . number_format($gaji['total'], 0, ',', '.') . "</strong></p>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>
