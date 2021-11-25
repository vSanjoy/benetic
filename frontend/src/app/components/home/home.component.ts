import { Component, OnInit, Inject } from '@angular/core';
import { from } from 'rxjs';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../services/http.service';
import { environment } from './../../../environments/environment';
import { ToastrService } from 'ngx-toastr';
import { OwlOptions } from 'ngx-owl-carousel-o';

declare const circularCarousel3:any;
declare const homePageCircular:any;
declare const equelHeight:any;

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})

export class HomeComponent implements OnInit { 
  banners:any = [];
  logos:any = [];
  widgets:any = [];
  homeDetails:any = [];
  homeDetailsImage1:any;
  beneticTurns:any = [];

  // for circualr slider
	idHome:any;
	counter:any= 1;

  constructor(
  	@Inject(Router) private router,
    @Inject(HttpService) private http,
    @Inject(ActivatedRoute) private route,
    private toastr: ToastrService
  ) { }

  ngOnInit(): void {
    this.homePageDetails();

    this.idHome = setInterval(() => {
			homePageCircular(this.counter);
			this.counter++;
		}, 10000);
  }

  // Destroy slider related things
	ngOnDestroy() {
		if (this.idHome) {
			clearInterval(this.idHome);
		}
	}

  // Getting home page details
  homePageDetails() {
    this.http.setModule('home').list({}).subscribe((response) => {
      if (response.home_page_details.status == 200) {
        // Banner
        this.banners = response.home_page_details.data.banner.list;
        this.banners.map((el) => {
          el.image = environment.image_url + response.home_page_details.data.banner.image_source + el.image;
        });
        // Logo
        this.logos = response.home_page_details.data.logo.list;
        this.logos.map((el) => {
          el.image = environment.image_url + response.home_page_details.data.logo.image_source + el.image;
        });
        // Cms Pages
        this.widgets = response.home_page_details.data.cms_page.list;
        this.widgets.map((el) => {
          if (el.home_widget_image != null) {
            el.home_widget_image = environment.image_url + response.home_page_details.data.cms_page.image_source + el.home_widget_image;
          }
        });
        // Home page details
        this.homeDetails = response.home_page_details.data.cms_page.home_page;
        this.homeDetailsImage1 = environment.image_url + response.home_page_details.data.cms_page.image_source + response.home_page_details.data.cms_page.home_page.image1;
        // Benetic turns
        this.beneticTurns = response.home_page_details.data.benetic_turn.list;
        this.beneticTurns.map((el) => {
          el.image = environment.image_url + response.home_page_details.data.benetic_turn.image_source + el.image;
        });
        
        circularCarousel3();
        equelHeight();
      } else {
        this.toastr.error('Oops! Something went wrong, please try again later.', 'Error!');
      }
    });
  }

  customOptions: OwlOptions = {
    loop: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: false,
    dots: false,
    autoplay:true,
    autoplayTimeout:9000,
    navSpeed: 700,
    margin:20,
    navText: ['Previous', 'Next'],
    responsive: {
      0: {
        items: 1 
      },
      400: {
        items: 1
      },
      740: {
        items: 1
      },
      940: {
        items: 1
      }
    },
    nav: false
  };

  logosliderOptions: OwlOptions = {
    loop: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: false,
    dots: false,
    margin:50,
    autoplay:true,
    autoplayTimeout:3000,
    navSpeed: 700,
    navText: ['Previous', 'Next'],
    responsive: {
      0: {
        items: 2 
      },
      400: {
        items: 2
      },
      740: {
        items: 3
      },
      940: {
        items: 3
      }
    },
    nav: false
  }

}
