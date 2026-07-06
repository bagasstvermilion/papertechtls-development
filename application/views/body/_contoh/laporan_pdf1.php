<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title_pdf;?></title>
        <style>
            /* custom paper size: width height; */
            @page { 
                    size: 300pt 360pt;
                    margin: 2mm;                    
                }
        </style>
    </head>
    <body>
        
        Page 1
        <div style="page-break-before: always;"></div>
        
        Page 2
        <div style="page-break-before: always;"></div>

        Page 3
        <div style="page-break-before: always;"></div>
    </body>
</html>