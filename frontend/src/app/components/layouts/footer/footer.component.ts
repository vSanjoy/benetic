import { Component, OnInit, Inject } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpService } from './../../../services/http.service';
import { environment } from './../../../../environments/environment';
import { DomSanitizer, SafeUrl, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.css']
})
export class FooterComponent implements OnInit {
  footerLogo:any;
  public untrustedUrl: any;
  learnMoreVideoUrl:SafeResourceUrl;
  footerDetails:any = [];
  currentYear:any;

  constructor(
    @Inject(Router) private router,
    @Inject(HttpService) private http,
    @Inject(ActivatedRoute) private route,
    private sanitizer: DomSanitizer,
  ) { }

  ngOnInit(): void {
    this.footerSectionDetails();
    this.currentYear = new Date().getFullYear();
  }

  footerSectionDetails() {
  	this.http.setModule('footer').list({}).subscribe((response) => {
      this.footerLogo = environment.image_url + response.footer_details.data.image_source + response.footer_details.data.site_settings.footer_logo;
      // Video
      this.untrustedUrl = environment.image_url + response.footer_details.data.image_source + response.footer_details.data.site_settings.learn_more_video;
      this.learnMoreVideoUrl = this.sanitizer.bypassSecurityTrustResourceUrl(this.untrustedUrl);

      this.footerDetails = response.footer_details.data.site_settings;      
    });
  }

}
