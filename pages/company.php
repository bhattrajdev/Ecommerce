<style>
    .heading {
        margin-top: 2rem;
        text-align: center;
    }

    .image-with-description {
        display: flex;
        width: 90%;
        height: 70vh;
    }

    .custom-line::before {
        content: '';
        background: var(--secondary_color);
        height: 5px;
        width: 300px;
        margin-left: auto;
        margin-right: auto;
        display: block;
        transform: translateY(15px);
    }

    .custom-line::after {
        content: '';
        background: var(--secondary_color);
        height: 10px;
        width: 50px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
        display: block;
        transform: translateY(8px);
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;
    }

    .image-container {
        flex: 1;
        /* padding: 30px; */
    }

    img {
        width: 100%;
        height: auto;
    }

    .description-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 2;
        padding: 30px;

    }

    .description-container p {
        max-width: 80%;
        font-size: 18px;
        line-height: 2;
    }

    /* for screen 1240px */
    @media screen and (max-width:1240px) {
        .description-container p {
            max-width: 90%;
            font-size: 16px;
            line-height: 1.5;
        }
    }

    /* for 940px screen */
    @media screen and (max-width:940px) {

        .image-with-description {
            display: flex;
            flex-direction: column;
            width: 90%;
            height: 150vh;
        }
     #our_services .image-with-description {
            display: flex;
            flex-direction: column-reverse;
            width: 90%;
            height: 150vh;
        }

        
        .heading {
            margin-top: 2rem;
            text-align: center;
            font-size: 22px;
        }

        .description-container p {
            max-width: 80%;
            font-size: 15px;
            line-height: 2;
        }

        .custom-line::before {
            content: '';
            background: var(--secondary_color);
            height: 5px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            transform: translateY(15px);
        }

        .custom-line::after {
            content: '';
            background: var(--secondary_color);
            height: 10px;
            width: 50px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 40px;
            display: block;
            transform: translateY(8px);
        }
    }
</style>
</head>

<body>

    <section id="about_us">
        <h1 class="heading ">About us</h1>
        <div class="custom-line"></div>
        <div class="image-with-description mx-auto">
            <div class="image-container">
                <img src="<?= url('public/images/about_us.jpg') ?>" alt="Image">
            </div>
            <div class="description-container">
                <p>
                    Welcome to Sneaker Station, your ultimate destination for the hottest and most exclusive sneakers! We take
                    pride in being the leading ecommerce platform that caters to sneaker enthusiasts worldwide. At Sneaker
                    Station, we believe that sneakers are more than just footwear; they represent a culture and a lifestyle.
                    Our mission is to provide you with a seamless shopping experience and access to the latest trends, limited
                    editions, and classic kicks, all under one virtual roof.
                </p>
            </div>
        </div>
    </section>

    <section id="our_services">
        <h1 class="heading">Our Services</h1>
        <div class="custom-line"></div>
        <div class="image-with-description mx-auto">
            <div class="description-container">
                <p>
                    "At Sneaker Station, we're your ultimate sneaker destination, bringing you a handpicked collection of the hottest and most
                    exclusive kicks. From new releases to gently used favorites, our platform caters to every sneakerhead's dream.
                    Step up your style with secure payments and top-notch customer support. Plus, become a seller and share your sneaker
                    passion with our vibrant community. Elevate your sneaker game today at Sneaker Station
                </p>
            </div>
            <div class="image-container">
                <img src="<?= url('public/images/our_services.jpg') ?>" alt="Image">
            </div>
        </div>
    </section>

    <section id="privacy_policy">
        <h1 class="heading">Privacy Policy </h1>
        <div class="custom-line"></div>
        <div class="image-with-description mx-auto">
            <div class="image-container">
                <img src="<?= url('public/images/privacy_policy.jpg') ?>" alt="Image">
            </div>
            <div class="description-container">
                <p style="margin-bottom: 3rem;">
                    At Sneaker Station, we prioritize the privacy and security of your personal information. We collect necessary data during registration
                    and browsing to enhance your shopping experience. Rest assured, we handle your data with utmost confidentiality and protect it from
                    unauthorized access. Your information is solely used for improving our services and providing personalized recommendations. Our commitment
                    to data protection ensures compliance with all relevant laws and regulations.
                </p>
            </div>
        </div>
    </section>