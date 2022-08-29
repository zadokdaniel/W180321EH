<?php
session_start();

require_once './app/helpers.php';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$sql = "
SELECT u.id AS user_id, p.id AS post_id, u.name, p.title, up.profile_image, p.article, DATE_FORMAT(p.created_at, '%d/%m/%Y %H:%i') date
FROM posts p
LEFT JOIN users u ON u.id = p.user_id
LEFT JOIN user_profile up ON u.id = up.user_id
ORDER BY p.created_at DESC
";
$result = mysqli_query($link, $sql);


$page_title = "BLOG";
include './tpl/header.php';
?>

<main class="container flex-fill">

    <!-- PAGE HEADER -->
    <section id="main-content-top">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">
                    <?= LOGO; ?> Blog
                </h1>
                <p>

                    <?php if (user_auth()) : ?>
                        <a href="./add_post.php" class="btn btn-primary mt-2">
                            Add New
                        </a>
                    <?php else : ?>
                        To add a post
                        <a href="./signup.php">create a user</a>
                        or
                        <a href="./signin.php">sign in</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </section>

    <!-- PAGE CONTENT -->
    <section id="main-content" class="continer mt-5">
        <div class="row mb-2">
            <div class="col-12">
                <h3><?= LOGO; ?> Posts</h3>
            </div>

            <?php if ($result && mysqli_num_rows($result) > 0) : ?>

                <?php while ($post = mysqli_fetch_assoc($result)) : ?>
                    <div class="row mb-2">
                        <div class="col-12 my-2">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div>
                                        <img height="25" class="me-2" src="./images/profiles/<?= $post['profile_image']; ?>">
                                        <span><?= $post['name']; ?></span>
                                    </div>
                                    <span><?= $post['date']; ?></span>
                                </div>

                                <div class="card-body">
                                    <h4><?= htmlspecialchars($post['title']); ?></h4>
                                    <p><?= nl2br(htmlspecialchars($post['article'])); ?></p>

                                    <?php if (user_auth() && $_SESSION['user_id'] === $post['user_id']) : ?>

                                        <div class="d-flex justify-content-end">
                                            <div class="dropdown">
                                                <a class="text-dark dropdown-toggle dropdown-toggle-no-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="./edit_post.php?pid=<?= $post['post_id']; ?>&<?= csrf_name(); ?>=<?= csrf(); ?>">
                                                            <i class="bi bi-pencil me-2"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="./delete_post.php?pid=<?= $post['post_id']; ?>&<?= csrf_name(); ?>=<?= csrf(); ?>">
                                                            <i class="bi bi-trash"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

            <?php else : ?>

                <div class="row mb-2">
                    <div class="col-12 text-center mt-5">
                        <h3>No posts yet. Be the first to post on our blog.</h3>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </section>


</main>

<?php include './tpl/footer.php'; ?>