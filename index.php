<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Upload souboru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

<body>

    <?php
    error_reporting(0);
    $uploadSuccess = true;

    function alert($number, $text)
    {
        $type = ($number == 1) ? "alert-danger" : "alert-success";
        echo ('<div class="alert ' . $type . '"  role="alert">' . $text . '</div>');
    }

    if ($_FILES) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["uploadedName"]["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $kind = explode('/', $_FILES['uploadedName']['type'])[0];

        if (file_exists($targetFile)) {
            alert(1, "Soubor již existuje!");
            $uploadSuccess = false;
        }

        if ($_FILES["uploadedName"]["size"] > 8000000) {
            alert(1, "Soubor je příliš velký");
            $uploadSuccess = false;
        }

        if ($kind !== "image" && $kind !== "audio" && $kind !== "video") {
            alert(1, "Bohužel jsou podporovány jen soubory typů JPG, JPEG, PNG a GIF.");
            $uploadSuccess = false;
        }

        if ($uploadSuccess) {

            if (move_uploaded_file($_FILES["uploadedName"]["tmp_name"], $targetFile))
                alert(2, "Soubor " . basename($_FILES["uploadedName"]["name"]) . " byl uložen.");
            else
                alert(1, "Bohužel došlo k chybě uploadu");
        }
    }

    ?>

    <div class="container-sm" style="padding-top:10vh">

        <form method='POST' action='index.php' enctype='multipart/form-data'>
            <div class="mb-3">
                <label for="formFile" class="form-label">File input</label>
                <input id="formFile" type="file" class=" form-control" name="uploadedName" accept="image/*, audio/*, video/*" />
                <input type="submit" class="btn btn-primary mb-3" style="margin-top: 1em" />
            </div>
        </form>

    </div>
    <div class="container-sm">

        <?php
        if ($kind === "image")
            echo "<img src='${targetFile}' style='width: 100%'>";
        else if ($kind === "audio")
            echo "<audio controls loop autoplay style='width: 100%'> <source src='${targetFile}' type='audio/{$fileType}'> nepodporováno </audio>";
        else if ($kind === "video")
            echo "<video controls autoplay loop muted width='100%'> <source src='${targetFile}' type='audio/{$fileType}'> nepodporováno </video>";
        ?>

    </div>
</body>

</html>