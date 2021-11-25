import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../services/http.service';
import { environment } from './../../../environments/environment';
import { ToastrService } from 'ngx-toastr';
import { OwlOptions } from 'ngx-owl-carousel-o';

declare const equelHeight:any;

@Component({
  selector: 'app-advisors',
  templateUrl: './advisors.component.html',
  styleUrls: ['./advisors.component.css']
})
export class AdvisorsComponent implements OnInit {
	pageDetails:any = [];
  pageBanner:any;
  benefits:any = [];
  widgetDetails:any = [];
  widgetImage:any;

  constructor(
		@Inject(Router) private router,
		@Inject(HttpService) private http,
    @Inject(ActivatedRoute) private route,
    private toastr: ToastrService
	) { }

  ngOnInit(): void {
		this.solutionPageDetails();
	}
	
	// Getting details
	solutionPageDetails() {
    this.http.setModule('advisors').list({}).subscribe((response) => {
			if (response.advisors_page_details.status == 200) {
        // Page details
        this.pageDetails = response.advisors_page_details.data.cms_page.page;
        this.pageBanner = environment.image_url + response.advisors_page_details.data.cms_page.image_source + response.advisors_page_details.data.cms_page.page.banner_image;
        // Benefits
        this.benefits = response.advisors_page_details.data.benefit.list;
        this.benefits.map((el) => {
            el.image = environment.image_url + response.advisors_page_details.data.benefit.image_source + el.image;
        });
        // Widget
        this.widgetDetails = response.advisors_page_details.data.proposal_generation.page;
        this.widgetImage = environment.image_url + response.advisors_page_details.data.cms_page.image_source + response.advisors_page_details.data.proposal_generation.page.image1;
        
        setTimeout(function() {
          equelHeight();
        }, 2000);
      } else {
        this.toastr.error('Oops! Something went wrong, please try again later.', 'Error!');
      }
		});
	}

  serviceOptions: OwlOptions = {
    loop: true,
    mouseDrag: true,
    touchDrag: true,
    pullDrag: false,
    dots: false,
    margin:30,
    center:true,
    autoplay:false,
    autoplayTimeout:5000,
    navSpeed: 700,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
    nav:true,
    responsive: {
      0: {
        items: 1 
      },
      400: {
        items: 2
      },
      740: {
        items: 2
      },
      940: {
        items: 3
      }
    },
  }

}
