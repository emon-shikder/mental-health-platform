<style>

footer.ft {
  background-color: black;
  color: white;
  font-family: Arial, sans-serif;
  padding: 40px 20px 0;
  text-align: left;
}

footer.ft .ct {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1200px;
  margin: 0 auto;
  gap: 30px;
}

footer.ft .sec {
  flex: 1 1 250px;
}

footer.ft .sec.logo {
  max-width: 300px;
}
footer.ft .lg {
  width: 150px;
  margin-bottom: 15px;
}
footer.ft .desc {
  font-size: 14px;
  line-height: 1.6;
  margin-bottom: 15px;
  color: gray;
}

footer.ft .soc {
  display: flex;
  gap: 10px;
}
footer.ft .soc .icon {
  width: 28px;
  height: 28px;
  cursor: pointer;
}
footer.ft .soc .icon:hover {
  opacity: 0.8;
}

footer.ft h4 {
  font-size: 16px;
  margin-bottom: 12px;
  color: white;
}
footer.ft ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
footer.ft ul li {
  margin-bottom: 8px;
}
footer.ft ul li a {
  color: silver;
  text-decoration: none;
}
footer.ft ul li a:hover {
  color: white;
}

footer.ft .emr-box {
  background-color: black;
  padding: 15px;
  border-radius: 6px;
  font-size: 14px;
  color: white;
  border: 1px solid white;
}
footer.ft .emr-title {
  color: red;
  margin-bottom: 6px;
  font-weight: bold;
}

footer.ft .btm {
  text-align: center;
  padding: 15px 10px;
  border-top: 1px solid white;
  margin-top: 30px;
  font-size: 13px;
  color: silver;
}
footer.ft .btm span.sup-avl {
  color: green;
  font-weight: bold;
}

@media (max-width: 768px) {
  footer.ft .ct {
    flex-direction: column;
    gap: 20px;
  }
  footer.ft .sec {
    max-width: 100%;
  }
  footer.ft .sec.logo {
    max-width: 100%;
    text-align: center;
  }
  footer.ft .soc {
    justify-content: center;
  }
}
</style>


<footer class="ft">
    <div class="ct">
        <div class="sec logo">
            <img src="logo.png" alt="Phyra Logo" class="lg">
            <p class="desc">
                A safe and supportive community for students to connect, share experiences, and access mental health resources. You're not alone in your journey.
            </p>
            <div class="soc">
                <a href="#"><img src="twitter-icon.png" alt="Twitter" class="icon"></a>
                <a href="#"><img src="instagram-icon.png" alt="Instagram" class="icon"></a>
                <a href="#"><img src="facebook-icon.png" alt="Facebook" class="icon"></a>
            </div>
        </div>

        <div class="sec qlk">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="forum.php">Community Forum</a></li>
                <li><a href="mood.php">Mood Tracker</a></li>
                <li><a href="resources.php">Resources</a></li>
            </ul>
        </div>

        <div class="sec sup">
            <h4>Support</h4>
            <ul>
                <li><a href="help.php">Help Center</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="privacy.php">Privacy Policy</a></li>
                <li><a href="terms.php">Terms of Service</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>

        <div class="sec emr">
            <h4>Emergency Resources</h4>
            <div class="emr-box">
                <p class="emr-title"><strong>Crisis Support</strong></p>
                <p>If you're in crisis, please call your local emergency number or a crisis hotline.</p>
                <p>📞 <strong>988</strong> - Suicide & Crisis Lifeline</p>
                <p>📞 <strong>1-800-273-8255</strong> - National Suicide Prevention</p>
                <p>💬 Crisis Text Line: Text <strong>HOME</strong> to <strong>741741</strong></p>
            </div>
        </div>
    </div>

    <div class="btm">
        <p>&copy; <?php echo date('Y'); ?> Phyra - Student Mental Health Support Platform. All rights reserved.</p>
        <p>Made with ❤️ for students &nbsp; | &nbsp; <span class="sup-avl">✔️ 24/7 Support Available</span></p>
    </div>
</footer>
