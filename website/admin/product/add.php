<?php
require_once ('../../db/dbhelper.php');

$id = $price = $title = $thumbnail = $content = $id_category = $amount ='';
if (!empty($_POST)) {
	if (isset($_POST['title'])) {
		$title = $_POST['title'];
		$title = str_replace('"', '\\"', $title);
	}
	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
    if (isset($_POST['price'])) {
		$price = $_POST['price'];
		$price = str_replace('"', '\\"', $price);
	}
	if (isset($_POST['amount'])) {
		$amount = $_POST['amount'];
		$amount = str_replace('"', '\\"', $amount);
	}
    if (isset($_POST['thumbnail'])) {
		$thumbnail = $_POST['thumbnail'];
		$thumbnail = str_replace('"', '\\"', $thumbnail);
	}
    if (isset($_POST['content'])) {
		$content = $_POST['content'];
		$content = str_replace('"', '\\"', $content);
	}
    if (isset($_POST['id_category'])) {
		$id_category = $_POST['id_category'];
	}

	if (!empty($title)) {
		$created_at = $updated_at = date('Y-m-d H:s:i');
		//Luu vao database
		if ($id == '') {
			$sql = 'insert into product(title, thumbnail, price, content, id_category, created_at, updated_at) 
            values ("'.$title.'", "'.$price.'", "'.$thumbnail.'", "'.$content.'", "'.$id_category.'", "'.$created_at.'", "'.$updated_at.'","'.$amount.'")';
		} else {
			$sql = 'update product set title = "'.$title.'", updated_at = "'.$updated_at.'", thumbnail ="'.$thumbnail.'", price = "'.$price.'", content = "'.$content.'", id_category = "'.$id_category.'", amount ="'.$amount.'" where id='.$id;		
		}

		execute($sql);

		header('Location: index.php');
		die();
	}
}

if (isset($_GET['id'])) {
	$id       = $_GET['id'];
	$sql      = 'select * from product where id = '.$id;
	$product = executeSingleResult($sql);
	if ($product != null) {
		$title = $product['title'];
		$price = $product['price'];
		$amount = $product['amount'];
		$thumbnail = $product['thumbnail'];
		$id_category = $product['id_category'];
		$content = $product['content'];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Thêm/Sửa Sản Phẩm</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<!-- summernote -->
	<!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
<body>
	<ul class="nav nav-tabs">
	  <li class="nav-item">
	    <a class="nav-link" href="../category/">Quản Lý Danh Mục</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href="index.php">Quản Lý Sản Phẩm</a>
	  </li>
	</ul>

	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h2 class="text-center">Thêm/Sửa Sản Phẩm</h2>
			</div>
			<div class="panel-body">
				<form method="post">
					<div class="form-group">
					  <label for="title">Tên Sản Phẩm:</label>
					  <input type="text" name="id" value="<?=$id?>" hidden="true">
					  <input required="true" type="text" class="form-control" id="title" name="title" value="<?=$title?>" >
                      </div>
                    <div class="form-group">
					  <label for="price">Danh Mục:</label>
					  <select class="form-control" name="id_category" id="id_category">
                        <option>-- Lựa chọn danh mục --</option> 
<?php
$sql          = 'select * from category';
$categoryList = executeResult($sql);
foreach ($categoryList as $item){
	if($item['id'] == $id_category) {
		echo '<option select value="'.$item['id'].'">'.$item['name'].'</option>';
	}else{
		echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
	}
}

?>
                    </select> 
                    </div>
                    </div>
                    <div class="form-group">
					  <label for="price">Giá Bán:</label>
					  <input required="true" type="number" class="form-control" id="price" name="price" value="<?=$price?>">
					</div>
					<div class="form-group">
					  <label for="amount">Số lượng(kg):</label>
					  <input required="true" type="number" class="form-control" id="amount" name="amount" value="<?=$amount?>">
					</div>
                    <div class="form-group">
					  <label for="thumbnail">Hình Ảnh:</label>
					  <input required="true" type="text" class="form-control" id="thumbnail" name="thumbnail" value="<?=$thumbnail?>" onchange=" updatethumbnail()">
					  <img src="<?=$thumbnail?>" style="max-width: 200px" id="img_thumbnail">
					</div>
                    <div class="form-group">
					  <label for="content">Nội dung:</label>
					  <textarea class="form-control" row="5" name="content" id="content"><?=$content?></textarea>
					</div>
					<button class="btn btn-success">Lưu</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript"> 
	    function updatethumbnail(){
		$('#img_thumbnail').attr('src' , $('#thumbnail').val())
	}

	$(function() {
		//doi websiteload noi dung => xu ly phan is
		$('#content').summernote({
          height: 350,
          })
       });
	
	</script>
</body>
</html>