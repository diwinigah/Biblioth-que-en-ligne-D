<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
footer {
    width: 100%;
    background-color: black !important;
    color: white !important;
    padding: 30px 0;
    text-align: center;
    margin-top: auto;
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 10px;
}

.fa {
    margin: 0;
    padding: 8px;
    font-size: 20px;
    width: 35px;
    height: 35px;
    text-align: center;
    text-decoration: none;
    border-radius: 50%;
    display: inline-block;
    transition: opacity 0.3s;
}

.fa:hover {
    opacity: .7;
}

.fa-facebook { background: #3B5998; color: white !important; }
.fa-linkedin { background: #0077B5; color: white !important; }
.fa-twitter { background: #55ACEE; color: white !important; }
.fa-instagram { background: #E4405F; color: white !important; }

.footer-info {
    font-size: 14px;
    line-height: 1.6;
    color: white !important;
}

.copyright {
    font-size: 12px;
    opacity: 0.7;
    margin-top: 10px;
    color: white !important;
}
</style>

<footer style="background-color: black !important; color: white !important;">
    <div class="footer-content">
        <h3 style="color: white !important;">Contacter nous via les réseaux sociaux</h3>

        <div class="social-icons">
            <a href="https://www.facebook.com/nathanael.saguintaah" class="fa fa-facebook"></a>
            <a href="https://www.linkedin.com/in/nathanael-saguintaah-b-4b1a1631b" class="fa fa-linkedin"></a>
        </div>

        <div class="footer-info">
            Email: <strong style="color: white !important;">winidorc1@gmail.com</strong> <br>
            Mobile: <strong style="color: white !important;">+228 93 40 37 68</strong>
        </div>

        <div class="copyright">
            &copy; <?php echo date("Y"); ?> Système de Gestion de Bibliothèque. Tous droits réservés.
        </div>
    </div>
</footer>
