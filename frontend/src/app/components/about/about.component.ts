import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../services/http.service';
import { environment } from './../../../environments/environment';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-about',
  templateUrl: './about.component.html',
  styleUrls: ['./about.component.css']
})
export class AboutComponent implements OnInit {
	pageDetails:any = [];
	teamMembers:any = [];
	detailsImage1:any;

  constructor(
		@Inject(Router) private router,
		@Inject(HttpService) private http,
		@Inject(ActivatedRoute) private route,
		private toastr: ToastrService
	) { }

  ngOnInit(): void {
		this.aboutPageDetails();
	}
	
	aboutPageDetails() {
		this.http.setModule('about_us').list({}).subscribe((response) => {
			if (response.about_page_details.status == 200) {
				// Page details
				this.pageDetails = response.about_page_details.data.cms_page.page;
				this.detailsImage1 = environment.image_url + 'cms/' + response.about_page_details.data.cms_page.page.image1;
				// Team members
				this.teamMembers = response.about_page_details.data.team_member.list;
				this.teamMembers.map((el) => {
					el.image = environment.image_url + response.about_page_details.data.team_member.image_source + el.image;
				});
			} else {
				this.toastr.error('Oops! Something went wrong.', 'Error!');
			}
		}, (error) => {
			this.toastr.error('Oops! Something went wrong.', 'Error!');
		});
	}

}
