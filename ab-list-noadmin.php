<?php
require __DIR__ . '/db_connect.php';
$pageName = 'ab-list';
$title = '商品列表';


$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? ($_GET['search']) : '';
$params = [];

$where = ' WHERE 1 '; //預設where的開頭
if (!empty($search)) {
    $where .= sprintf(" AND `category` LIKE %s ", $pdo->quote('%' . $search . '%'));
    $params['search'] = $search;
}

$perPage = 4;
$t_sql = "SELECT COUNT(1) FROM product $where ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);
if ($page > $totalPages) $page = $totalPages;
if ($page < 1) $page = 1;

$p_sql = sprintf(
    "SELECT * FROM product %s
    ORDER BY sid LIMIT %s, %s",
    $where,
    ($page - 1) * $perPage,
    $perPage
);


$statement = $pdo->query($p_sql);
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<? include __DIR__.'/parts/html-head.php'; ?>
<? include __DIR__.'/parts/navbar.php'; ?>


<style>
    .remove-icon a i {
        color: palevioletred;
    }

    .edit-icon a i {
        color: #b7733c;
    }

    #imgs {
        height: 150px;
        width: 150px;
        background-color: grey;
    }

    .page-link {
        border-style: none;
    }

    .page-item>a {
        color: grey;
    }

    /* #e2e678 */
    .page-item.active .page-link {
        background-color: #679b8c;
    }
</style>


<div class="container">

    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination my-2 ">
                    <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $params['page'] = 1;
                                                    echo http_build_query($params); ?>">
                            <!-- 結果：?search=陳&page=1
                            http_build_query(陣列)會輸出query string，例：foo=bar但不包含'？'
                            所以'？'要自己打 -->
                            <i class="fas fa-angle-double-left"></i>
                        </a></li>

                    <li class="page-item  <?= $page == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $params['page'] = $page - 1;
                                                    echo http_build_query($params); ?>">
                            <i class="fas fa-angle-left"></i>
                        </a></li>

                    <?php for ($i = 1; $i <= $totalPages; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?<?php $params['page'] = $i;
                                                            echo http_build_query($params);  ?>">
                                    <?= $i ?>
                                </a></li>
                    <?php endif;
                    endfor ?>

                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $params['page'] = $page + 1;
                                                    echo http_build_query($params); ?>">
                            <i class="fas fa-angle-right"></i>
                        </a></li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?<?php $params['page'] = $totalPages;
                                                    echo http_build_query($params); ?>">
                            <i class="fas fa-angle-double-right"></i>
                        </a></li>
                </ul>
            </nav>
        </div>
        <div class="col d-flex flex-row-reverse bd-highlight">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search category" aria-label="Search" value="<?= htmlentities($search) ?>">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>



    <div class="row">
        <div class="col">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>


                        <th scope="col">sid</th>
                        <th scope="col">product_name</th>
                        <th scope="col">photo</th>
                        <th scope="col">category</th>
                        <th scope="col">price</th>
                        <th scope="col">color</th>
                        <th scope="col">size</th>
                        <th scope="col">introduction</th>


                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($row as $r) : ?>
                        <tr>

                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['product_name'] ?></td>
                            <td>
                                <!-- <div id="imgs"></div> -->
                                <img src="imgs/<?= $r['photo'] ?>" style="height:auto;width:150px">
                            </td>
                            <td><?= $r['category'] ?></td>
                            <td><?= $r['price'] ?></td>
                            <td><?= $r['color'] ?></td>
                            <td><?= $r['size'] ?></td>
                            <td><?= $r['introduction'] ?></td>


                        </tr>
                    <?php endforeach ?>


                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>

<!-- <script>
    function del_it(event, sid) {

        if (!confirm(`是否刪除編號${sid}的資料?`)) {
            event.preventDefault();
        }

    }
</script> -->





<?php include __DIR__ . '/parts/html-footer.php'; ?>