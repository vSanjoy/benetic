import { Component, OnInit, Inject } from '@angular/core';
import { from } from 'rxjs';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../services/http.service';
import { environment } from './../../../environments/environment';
import { ToastrService } from 'ngx-toastr';

declare const circularCarousel2:any;
declare const platFormPageCircular:any;

@Component({
  selector: 'app-platform',
  templateUrl: './platform.component.html',
  styleUrls: ['./platform.component.css']
})
export class PlatformComponent implements OnInit {
	pageDetails:any = [];
	howItWorks:any = [];
	detailsImage1:any;

	// for circualr slider
	id:any;
	con:any= 1;

	constructor(
		@Inject(Router) private router,
	 	@Inject(HttpService) private http,
		@Inject(ActivatedRoute) private route,
		private toastr: ToastrService
	) { }
	  
  ngOnInit() {
		this.platformPageDetails();

		this.id = setInterval(() => {
			platFormPageCircular(this.con);
			this.con++;
		}, 10000);
	}

	// Destroy slider related things
	ngOnDestroy() {
		if (this.id) {
			clearInterval(this.id);
		}
	}
	
	// Getting details
	platformPageDetails() {
		this.http.setModule('platform').list({}).subscribe((response) => {
			if (response.platform_page_details.status == 200) {
				// Page details
				this.pageDetails = response.platform_page_details.data.cms_page.page;
				this.detailsImage1 = environment.image_url + 'cms/' + response.platform_page_details.data.cms_page.page.image1;
				// How it work
				this.howItWorks = response.platform_page_details.data.how_it_work.list;
				this.howItWorks.map((el) => {
					el.image = environment.image_url + response.platform_page_details.data.how_it_work.image_source + el.image;
				});

				circularCarousel2();				
			} else {
        this.toastr.error('Oops! Something went wrong.', 'Error!');
      }
		}, (error) => {
      this.toastr.error('Oops! Something went wrong.', 'Error!');
    });
	}

	width: number = 100;
	height: number = 100;
	myStyle: Object = {
		'position': 'relative',
		'width': '100%',
		'height': '100%',
		'z-index': 0,
		'top': 0,
		'left': 0,
		'right': 0,
		'bottom': 0,
	};
	myParams: object = {
		"particles": {
			"number": {
				"value": 80,
				"density": {
					"enable": true,
					"value_area": 800
				}
			},
			"color": {
				"value": "#a8b1b3"
			},
			"shape": {
				"type": "polygon",
				"polygon": {
					"nb_sides": 7
				},
				"image": {
					"src": "img/github.svg",
					"width": 100,
					"height": 100
				}
			},
			"opacity": {
				"value": 0.6,
				"random": false,
				"anim": {
					"enable": false,
					"speed": 1,
					"opacity_min": 0.1,
					"sync": false
				}
			},
			"size": {
				"value": 4,
				"random": true,
				"anim": {
					"enable": false,
					"speed": 40,
					"size_min": 0.1,
					"sync": false
				}
			},
			"line_linked": {
				"enable": true,
				"distance": 150,
				"color": "#9ca3a5",
				"opacity": 0.4,
				"width": 1.5
			},
			"move": {
				"enable": true,
				"speed": 4,
				"direction": "none",
				"random": false,
				"straight": false,
				"out_mode": "out",
				"bounce": false,
				"attract": {
					"enable": false,
					"rotateX": 600,
					"rotateY": 1200
				}
			}
		},
		"interactivity": {
			"detect_on": "canvas",
			"events": {
				"onhover": {
					"enable": true,
					"mode": "repulse"
				},
				"onclick": {
					"enable": true,
					"mode": "push"
				},
				"resize": true
			},
			"modes": {
				"grab": {
					"distance": 400,
					"line_linked": {
						"opacity": 1
					}
				},
				"bubble": {
					"distance": 400,
					"size": 40,
					"duration": 2,
					"opacity": 8,
					"speed": 3
				},
				"repulse": {
					"distance": 200,
					"duration": 0.4
				},
				"push": {
					"particles_nb": 4
				},
				"remove": {
					"particles_nb": 2
				}
			}
		},
		"retina_detect": true
	}; 

}
