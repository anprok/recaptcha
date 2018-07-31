<?php
/**
 * @copyright Copyright (c) 2015, Google Inc.
 * @link      https://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
// Initiate the autoloader. The file should be generated by Composer.
// You will provide your own autoloader or require the files directly if you did
// not install via Composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = '';
$secret = '';

// Copy the config.php.dist file to config.php and update it with your keys to run the examples
if ($siteKey == '' && is_readable(__DIR__ . '/config.php')) {
    $config = include __DIR__ . '/config.php';
    $siteKey = $config['v3']['site'];
    $secret = $config['v3']['secret'];
}

// reCAPTCHA supports 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'en';


?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,height=device-height,minimum-scale=1">
<link rel="shortcut icon" href="https://www.gstatic.com/recaptcha/admin/favicon.ico" type="image/x-icon"/>
<link rel="canonical" href="https://recaptcha-demo.appspot.com/recaptcha-v2-request-scores.php">

<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "WebSite",
    "name": "reCAPTCHA demo - Request scores",
    "url": "https://recaptcha-demo.appspot.com/recaptcha-v2-request-scores.php"
  }
</script>

<meta name="description" content="reCAPTCHA demo - Request scores" />
<meta property="og:url" content="https://recaptcha-demo.appspot.com/recaptcha-v2-request-scores.php" />
<meta property="og:type" content="website" />
<meta property="og:title" content="reCAPTCHA demo - Request scores" />
<meta property="og:description" content="reCAPTCHA demo - Request scores" />
<link rel="stylesheet" type="text/css" href="/examples.css">

<title>reCAPTCHA demo - Request scores</title>
<header>
    <h1>reCAPTCHA demo</h1><h2>Request scores</h2>
    <p><a href="/">↤ Home</a></p>
</header>
<main>
<?php
if ($siteKey === '' || $secret === ''):
?>
    <h2>Add your keys</h2>
    <p>If you do not have keys already then visit <kbd> <a href = "https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a></kbd> to generate them. Edit this file and set the respective keys in <kbd>$siteKey</kbd> and <kbd>$secret</kbd>. Reload the page after this.</p>
    <?php
else:
    // Add the g-recaptcha tag to the form you want to include the reCAPTCHA element
    ?>
    <p>reCAPTCHA will provide a score for this request.</p>
    <ol id="recaptcha-steps">
        <li class="step0">reCAPTCHA script loading</li>
        <li style="display:none" class="step1"><kbd>grecaptcha.ready()</kbd> fired, calling <pre>grecaptcha.execute('<?php echo $siteKey; ?>', {action: 'homepage'})'</pre></li>
        <li style="display:none" class="step2">Received token from reCAPTCHA service, sending to our backend with <kbd>fetch('/recaptcha-v3-verify.php?token='+<span class="token">123</span>)</kbd></li>
        <li style="display:none" class="step3">Received response from our backend: <pre class="response">response</pre></li>
    </ol>
    <p><a href="/recaptcha-v3-request-scores.php">⟳ Try again</a></p>

    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey; ?>"></script>
    <script>
    const steps = document.getElementById('recaptcha-steps');
    grecaptcha.ready(function() {
        document.querySelector('.step1').style.display = 'list-item';
        grecaptcha.execute('<?php echo $siteKey; ?>', {action: 'homepage'}).then(function(token) {
            document.querySelector('.token').innerHTML = token;
            document.querySelector('.step2').style.display = 'list-item';

            fetch('/recaptcha-v3-verify.php?token='+token).then(function(response) {
                response.json().then(function(data) {
                    document.querySelector('.response').innerHTML = JSON.stringify(data);
                    document.querySelector('.step3').style.display = 'list-item';
                });
            });
        });
    });
</script>
    <?php
endif;?>
</main>

<!-- Google Analytics - just ignore this -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-123057962-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-123057962-1');
</script>
