<?php
require_once('./config/database.php');

class crud
{
	private $conn;
	
	function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}		
	
	public function create($nama,$password,$limit_waktu,$tgl_exp)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO users(nama,password,limit_waktu,tgl_exp) VALUES(:nama, :password, :limit_waktu, :tgl_exp)");
			$stmt->bindparam(":nama",$nama);
			$stmt->bindparam(":password",$password);
			$stmt->bindparam(":limit_waktu",$limit_waktu);
			$stmt->bindparam(":tgl_exp",$tgl_exp);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
	
	public function sec2str($s) { 
	    if ($s >= 604800) { 
	        $w = floor($s / 604800); 
	        $s = $s % 604800; 
	        $string = $w.'w '; 
	    } else @$string .= '0w '; 
	     
	    if ($s >= 86400) { 
	        $d = floor($s / 86400); 
	        $s = $s % 86400; 
	        $string .= $d.'d '; 
	    } else @$string .= '0d '; 
	     
	    if ($s >= 3600) { 
	        $h = floor($s / 3600); 
	        $s = $s % 3600; 
	        $string .= str_pad($h,2,'0',STR_PAD_LEFT).':'; 
	    } else $string .= '00:'; 
	     
	    if ($s >= 60) { 
	        $i = floor($s / 60); 
	        $s = $s % 60; 
	        $string .= str_pad($i,2,'0',STR_PAD_LEFT).':'; 
	    } else $string .= '00:'; 
	     
	    return $string.str_pad($s,2,'0',STR_PAD_LEFT); 
     
	} 

	public function str2sec($str) { 
	    preg_match('|([0-9]+)w|siU',$str,$w); 
	    preg_match('|([0-9]+)d|siU',$str,$d); 
	    preg_match('|([0-9]+):([0-9]+):([0-9]+)|siU',$str,$m); 
	    @$s += $w[1] * 604800; 
	    @$s += $d[1] * 86400; 
	    @$s += $m[1] * 3600; 
	    @$s += $m[2] * 60; 
	    @$s += $m[3]; 
	    return $s; 
	} 

	public function getID($id)
	{
		$stmt = $this->conn->prepare("SELECT * FROM users WHERE id=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	
	public function update($id,$soal,$idkat)
	{
		try
		{
			$stmt=$this->conn->prepare("UPDATE soal SET soal=:soal, 
		                                               id_kategori=:idkat, 
													WHERE id=:id ");
			$stmt->bindparam(":soal",$soal);
			$stmt->bindparam(":idkat",$idkat);
			$stmt->bindparam(":id",$id);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	
	public function delete($id)
	{
		$stmt = $this->conn->prepare("DELETE FROM users WHERE nama=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}
	
	public function pilihpaket($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if ($stmt->rowCount() > 0) { ?>
		  <select name="paket" class="form-control">
	    <?php foreach ($results as $row) { ?>
	      <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_paket']; ?></option>
	    <?php } ?>
	  	</select>
		<?php }
	}


	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lihat($data) { 
	    preg_match('|([0-9]+)w|siU',$str,$w); 
	    preg_match('|([0-9]+)d|siU',$str,$d); 
	    preg_match('|([0-9]+):([0-9]+):([0-9]+)|siU',$str,$m); 
	    @$s += $w[1] * 604800; 
	    @$s += $d[1] * 86400; 
	    @$s += $m[1] * 3600; 
	    @$s += $m[2] * 60; 
	    @$s += $m[3]; 
	    return $s; 
	} 



	/* paging */
	
	public function dataview($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		  date_default_timezone_set('Asia/Makassar');
		  $tgl_sekarang = date('Y-m-d H:i:s');


		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>
                <tr>
                <td><?php print($row['nama']); ?></td>
                <td><?php print($row['password']); ?></td>
                <td><?php print($row['limit_waktu']); ?></td>
                <td><?php print($row['tgl_submit']); ?></td>
                <td><?php print($row['tgl_exp']); ?></td>
                <td>
                <?php
                if ($row['tgl_exp'] > $tgl_sekarang) {
					$start_date = new DateTime($tgl_sekarang);
					$since_start = $start_date->diff(new DateTime($row['tgl_exp']));
					echo $since_start->y.' <b>Tahun</b> ';
					echo $since_start->m.' <b>Bulan</b> ';
					echo $since_start->d.' <b>Hari</b> ';
					echo $since_start->h.' <i>jam</i> ';
					echo $since_start->i.' <i>menit</i> ';
					echo $since_start->s.' <i>detik</i> ';
				}
				else {
					echo "Waktu telah habis";
				}
                ?>
                <td width="9%" align="center">
    	            <a href="?edit_id=<?= $row['id'] ?>#ubahdata"><i class="glyphicon glyphicon-edit"></i>Ubah</a>
                </td>
                <td width="9%" align="center"> 
					<a href="user.php?hapus_id=<?= $row['nama'] ?>" class="hapus" data-id="<?= $row['nama'] ?>"><i class="glyphicon glyphicon-remove-circle"></i>Hapus</a>
                </td>
                </tr>
        <?php
			}
		}
		else
		{
		
		?>
            <tr>
            <td>Data tidak ditemukan.</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        <?php
		}
		
	}
	
	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	
	public function paginglink($query,$records_per_page)
	{
		
		$self = $_SERVER['PHP_SELF'];
		
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		
		$total_no_of_records = $stmt->rowCount();
		
		if($total_no_of_records > 0)
		{
			?><ul class="pagination"><?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;
			if(isset($_GET["page_no"]))
			{
				$current_page=$_GET["page_no"];
			}
			if($current_page!=1)
			{
				$previous =$current_page-1;
				echo "<li><a href='".$self."?page_no=1'>First</a></li>";
				echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
			}
			for($i=1;$i<=$total_no_of_pages;$i++)
			{
				if($i==$current_page)
				{
					echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
				}
				else
				{
					echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
				echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
			}
			?></ul><?php
		}
	}
	
	/* paging */
	

	
	
}

$crud = new crud();