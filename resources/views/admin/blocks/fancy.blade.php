<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"/>
<style>
    a[data-fancybox] img {
        cursor: zoom-in;
    }
.fancybox-gallery a:hover{
    text-decoration: none !important;
}
.fancybox__backdrop::after {
  content: "";
  position: absolute;
  width: 10%;
  height: 10%;
  filter: blur(2px);
  left: 50%;
  top: 50%;
  transform: scale(11);
  opacity: 0.3;
  background-image: var(--bg-image);
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
}

.fancybox__container {
  --fancybox-bg: #000;

  --fancybox-thumbs-width: 48px;
  --fancybox-thumbs-ratio: 1;

  --carousel-button-bg: rgb(91 78 76 / 74%);

  --carousel-button-svg-width: 24px;
  --carousel-button-svg-height: 24px;

  --carousel-button-svg-stroke-width: 2.5;
}

.fancybox__nav {
  --carousel-button-svg-width: 24px;
  --carousel-button-svg-height: 24px;
}

.fancybox__nav .carousel__button.is-prev {
  left: 20px;
}

.fancybox__nav .carousel__button.is-next {
  right: 20px;
}

.carousel__button.is-close {
  right: auto;
  top: 20px;
  left: 20px;
}

.fancybox__slide {
  padding: 8px 88px;
}

/* Thumbnails */
.fancybox__thumbs .carousel__slide {
  padding: 8px 8px 16px 8px;
}

.is-nav-selected::after {
  display: none;
}

.fancybox__thumb {
  border-radius: 6px;
  opacity: 0.4;
}

.fancybox__thumb:hover,
.is-nav-selected .fancybox__thumb {
  border-radius: 6px;
  opacity: 1;
}

.is-nav-selected .fancybox__thumb::after {
  display: none;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script>
    $(document).ready(function() {
        // window.Fancybox = Fancybox; 
        window.Fancybox = Fancybox.bind('[data-fancybox="gallery"]', {
            dragToClose: false,

            Toolbar: false,
            closeButton: "top",

            Image: {
                zoom: false,
            },

            on: {
                initCarousel: (fancybox) => {
                    const slide = fancybox.Carousel.slides[fancybox.Carousel.page];

                    fancybox.$container.style.setProperty(
                        "--bg-image",
                        `url("${slide.$thumb.src}")`
                    );
                },
                "Carousel.change": (fancybox, carousel, to, from) => {
                    const slide = carousel.slides[to];

                    fancybox.$container.style.setProperty(
                        "--bg-image",
                        `url("${slide.$thumb.src}")`
                    );
                },
            },
        });
    });
</script>