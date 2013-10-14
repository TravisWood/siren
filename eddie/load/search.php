<? include('../includes/config.php');

$from = $_POST['from'];
$to = $_POST['to'];
$client = $_POST['client_id'];
$status = $_POST['status'];
$today = date('Y-m-d');

if (!empty($from)):
	$extrasql .= " AND documents.inserted >= '".date('Y-m-d', strtotime($from))."'";
else:
	$extrasql .= '';
endif;

if (!empty($to)):
	$extrasql .= " AND documents.inserted <= '".date('Y-m-d', strtotime($to))."'";
else:
	$extrasql .= '';
endif;

if (!empty($client)):
	$extrasql .= " AND clients.id = '$client'";
else:
	$extrasql .= '';
endif;

if (!empty($status)):
	$extrasql .= " AND documents.status = '$status'";
else:
	$extrasql .= '';
endif;

$limit = 10;

if (!empty($_POST['loadmore'])):
	$limit = $limit * 2;
endif;


$html = '<table class="table table-striped" id="filterT">
        
        	<thead>
            	<th style="text-align:center">ID</th>
            	<th>Client Name</th>
                <th>Sent To</th>
                <th>Document</th>
                <th style="text-align:center;">Status</th>
				<th style="text-align:center;">Date Inserted</th>
				<th style="text-align:center;">Date Signed</th>
				<th>&nbsp;</th>
            </thead>
        
        	<tbody>';
			$sql = "SELECT
            documents.id AS doc_id,
            documents.client_id,
            documents.document,
			documents.user_requested,
            documents.inserted,
            documents.user_id,
			documents.date_signed,
            documents.status,
			documents.secret_key,
            clients.id,
            clients.business_name,
			users.id AS user_id,
			users.first_name,
			users.last_name
            FROM documents, clients, users
			WHERE documents.client_id = clients.id
			AND documents.user_requested = users.id $extrasql LIMIT $limit";
            
            $clients = R::getAll($sql); 
			$count = count($clients);
            
            foreach ($clients as $key => $client): 
			
			$type = pathinfo($client['document'], PATHINFO_EXTENSION);	
			
			if ($client['date_signed'] == NULL):
				$signed = 'N/A';
			else:
				$signed = date('m/d/Y', strtotime($client['date_signed']));
			endif;	
			
			if ($client['status'] == 'unsigned'):
				$icon = 'remove';
				$email_class = '';
			else:
				$icon = 'envelope';
				$email_class = 'emailDoc';
			endif;
			
			$html .= '          
            	<tr>
                	<td style="text-align:center">'.$client['doc_id'].'</td>
                	<td>'.$client['business_name'].'</td>
                    <td>'.$client['first_name'].' '.$client['last_name'].'</td>
                    <td><img src="img/icon-'.$type.'.png" /> <a href="uploads/documents/'.$client['client_id'].'/'.$client['document'].'">'.$client['document'].'</a></td>
					<td style="text-align:center">'.$client['status'].'</td>
					<td style="text-align:center">'.date('m/d/Y', strtotime($client['inserted'])).'</td>
					<td style="text-align:center">'.$signed.'</td>
					<td style="text-align:center"><a href="sign.php?key='.$client['secret_key'].'" title="View Document" target="_blank"><i class="icon icon-search"></i></a> <a href="#" title="Email Document Details" class="'.$email_class.'" data-id="'.$client['doc_id'].'"><i class="icon icon-'.$icon.'"></i></a></td>
                </tr>';
            
            endforeach; 
           $html .= '</tbody>      
        </table>';
		
		if ($count > 10):
		$html .= '<p class="center"><button class="btn btn-large loadmore">Load More</button></p>';
		endif;

echo json_encode(array('content' => $html));