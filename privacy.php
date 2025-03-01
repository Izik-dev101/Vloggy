<?php include 'header.php' ?>
<section id="privacy">
    <article class="innerprice">
        <div id="congolomate">
            <h3>Vloggy Cares About Your Privacy</h3>
            <p class="juganut">
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
        <div class="adipisicing">
            <form action="" method="POST">
                <ul id="cupiditate">
                    <li class="quaerat"><button name="accept" type="submit">I Accept</button></li>
                    <li class="commodi"><button name="decline" type="submit">I Decline</button></li>
                </ul>
            </form>       
         </div>
    </article>
</section>
<?php include 'footer.php' ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accept'])) {
        // Set cookie for accepted privacy policy
        setcookie('privacy_accepted', 'true', time() + 3600 * 24 * 365, '/'); // 1 year validity
        header('Location: dashboard/index.php'); // Redirect to the homepage or another page
        exit();
    } elseif (isset($_POST['decline'])) {
        // Set cookie for declined privacy policy
        setcookie('privacy_accepted', 'false', time() + 3600 * 24 * 365, '/');
        header('Location: index.php'); // Redirect to a page explaining the consequences
        exit();
    }
}
?>