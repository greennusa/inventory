<?php 
	$date = date('d/m/Y');
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=kategori-".$date.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Excel Kategori</title>
</head>
<body>
	<table >
        <tr>
            <th>Id</th>
            <th>Nama</th>
        </tr>
        
        @foreach($mereks as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->nama }}</td>
            </tr>
           
        @endforeach
    </table>
</body>
</html>