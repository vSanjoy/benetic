import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../services/http.service';
import { environment } from './../../../environments/environment';
import { ToastrService } from 'ngx-toastr';
import { OwlOptions } from 'ngx-owl-carousel-o';

declare const equelHeight:any;

@Component({
  selector: 'app-recordkeepers',
  templateUrl: './recordkeepers.component.html',
  styleUrls: ['./recordkeepers.component.css']
})
export class RecordkeepersComponent implements OnInit {
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
  	// equelHeight();
    this.recordkeeperPageDetails();
  }

  recordkeeperPageDetails() {
    this.http.setModule('recordkeeper').list({}).subscribe((response) => {
			if (response.recordkeeper_page_details.status == 200) {
				// Page details
        this.pageDetails = response.recordkeeper_page_details.data.cms_page.page;
        this.pageBanner = environment.image_url + response.recordkeeper_page_details.data.cms_page.image_source + response.recordkeeper_page_details.data.cms_page.page.banner_image;
        // Benefits
        this.benefits = response.recordkeeper_page_details.data.benefit.list;
        this.benefits.map((el) => {
            el.image = environment.image_url + response.recordkeeper_page_details.data.benefit.image_source + el.image;
        });
        // Widget
        this.widgetDetails = response.recordkeeper_page_details.data.online_storefront.page;
        this.widgetImage = environment.image_url + response.recordkeeper_page_details.data.cms_page.image_source + response.recordkeeper_page_details.data.online_storefront.page.image1;

        setTimeout(function() {
          equelHeight();
        }, 2000);
			} else {
        this.toastr.error('Oops! Something went wrong.', 'Error!');
      }
		}, (error) => {
      this.toastr.error('Oops! Something went wrong.', 'Error!');
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
