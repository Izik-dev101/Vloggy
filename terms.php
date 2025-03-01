<?php include 'header.php' ?>
<section id="termsphp">
    <article class="innerterms">
        <div id="congalomatoy">
            <h3>Our Terms & Conditions</h3>
            <p class="joggernoy">
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            Lorem ipsum dolor sit amet consectetur adipisicing elit dolor sit amet consectetur adipisicing elit.
            Molestias commodi sint quaerat hic sapiente cupiditate ipsam maiores, praesentium sed iusto.
            </p>
        </div>
        <div class="molestias">
            <form action="" method="POST">
                <ul id="cupdiytated">
                    <li class="sapienter"><button name="agree" type="submit">I Accept</button></li>
                    <li class="commoditing"><button name="reject" type="submit">I Decline</button></li>
                </ul>
            </form>
        </div>
    </article>
</section>
<?php include 'footer.php' ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agree'])) {
        // Set cookie for accepted privacy policy
        setcookie('privacy_accepted', 'true', time() + 3600 * 24 * 365, '/'); // 1 year validity
        header('Location: dashboard/index.php'); // Redirect to the homepage or another page
        exit();
    } elseif (isset($_POST['reject'])) {
        // Set cookie for declined privacy policy
        setcookie('privacy_accepted', 'false', time() + 3600 * 24 * 365, '/');
        header('Location: index.php'); // Redirect to a page explaining the consequences
        exit();
    }
}
?>