<?php 
	$date = date('d/m/Y');
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=unit-".$date.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Excel Unit</title>
</head>
<body>
	<table >
        <tr>
            <th>Id</th>
            <th>Kode</th>
          
            <th>Jenis Unit</th>
            <th>No.S/N</th>
            <th>No.E/N</th>
           
        </tr>
        
        @foreach($mereks as $data)
            <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->kode }}</td>
              
                <td>{{ $data->jenis_unit->nama }}</td>
                <td>{{ $data->no_sn }}</td>
                <td>{{ $data->no_en }}</td>
               
            </tr>
           
        @endforeach
    </table>
</body>
</html>