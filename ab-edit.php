<?php

require __DIR__ . '/is_admin.php';
require __DIR__ . '/db_connect.php';

$title = '修改商品資訊';

if (!isset($_GET['sid'])) {
    header('Location: ab-list.php');
    exit;
}

$sid = intval($_GET['sid']);

$row = $pdo
    ->query("SELECT * FROM `product` WHERE sid=$sid ")
    ->fetch();


//如果資料是空值就跳回ab-list.php
if (empty($row)) {
    header('Location: ab-list.php');
    exit;
}
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>

<style>
    form small.error-msg {
        color: red;
    }

    .bg-trans {
        background-color: transparent;
    }
</style>


<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6">
            <!-- <div class="alert alert-danger" role="alert" id="info" style="display: none">
                錯誤
            </div> -->

            <div class="card bg-trans">
                <div class="card-body">
                    <h3 class="card-title" style="color: #679b8c;">修改商品資訊</h3>
                    <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                        <input type="hidden" name="sid" value="<?= $sid ?>">
                        <div class="form-group">
                            <label for="product_name">** product_name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required value="<?= htmlentities($row['product_name']) ?>">
                            <small class="form-text error-msg" style="display: none;"></small>
                        </div>
                        <div class="form-group">
                            <label for="photo">photo</label>
                            <br>
                            <img id="preview" src="imgs/<?= $row['photo'] ?>" style="height:auto;width:250px">

                            <input type="file" id="photo" name="photo" accept="image/*" onchange="fileChange()">
                        </div>
                        <div class="form-group">
                            <label for="category">category</label>
                            <br>
                            <select name="category" id="category">
                            </select>

                            <!-- <input type="text" class="form-control" id="category" name="category" disabled value="<?php// htmlentities($row['category']) ?>"> -->
                        </div>
                        <div class="form-group">
                            <label for="price">price</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= htmlentities($row['price']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="color">color</label>
                            <input type="text" class="form-control" id="color" name="color" value="<?= htmlentities($row['color']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="size">size</label>
                            <input type="text" class="form-control" id="size" name="size" value="<?= htmlentities($row['size']) ?>">
                        </div>
                        <div class="form-group">
                            <label for="introduction">introduction</label>
                            <textarea class="form-control" name="introduction" id="introduction" cols="30" rows="3"><?= htmlentities($row['introduction']) ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning">修改</button>

                    </form>
                </div>
            </div>



        </div>
    </div>
</div>


<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    // const info = document.querySelector('#info');
    const product_name = document.querySelector('#product_name');
    const preview = document.querySelector('#preview');
    const photo = document.querySelector('#photo');
    const category = document.querySelector('#category');
    const reader = new FileReader();

    const plate = ['杯具', '餐盤', '花器', '筷架'];
    let OptionString = '<option value="">分類</option>'
    for (let i = 0; i < plate.length; i++) {
        OptionString += `<option value="${plate[i]}">${plate[i]}</option>`
    }
    category.innerHTML = OptionString

    reader.addEventListener('load', function(event) {
        preview.src = reader.result;
        preview.style.height = 'auto';
    });

    function fileChange() {
        reader.readAsDataURL(photo.files[0]);

        console.log(photo.files.length);
        console.log(photo.files[0]);
    }

    function checkForm() {
        // info.style.display = "none";
        let isPass = true;

        product_name.style.borderColor = '#CCCCCC';
        product_name.nextElementSibling.style.display = 'none';

        if (!product_name.value) {
            isPass = false;
            product_name.style.borderColor = 'red';
            let small = product_name.closest('.form-group').querySelector('small');
            small.innerText = "請輸入商品名稱";
            small.style.display = 'block';
        }

        if (isPass) {
            const fd = new FormData(document.form1);

            fetch('ab-edit-api.php', {
                    method: 'POST',
                    body: fd
                })

                .then(r => r.json())
                .then(obj => {
                    console.log(obj);

                    if (obj.success) {
                        alert('修改成功！');
                        window.location.href = 'ab-list.php';
                    } else {
                        alert('修改失敗QQ');
                    }
                    // info.style.display = 'block';
                });
        }


    }
</script>

<?php include __DIR__ . '/parts/html-footer.php'; ?>