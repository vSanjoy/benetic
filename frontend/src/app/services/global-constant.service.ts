import { Injectable } from '@angular/core';
import { environment } from './../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class GlobalConstantService {

  constructor() { }

  API_URL = environment.api_url;

  public apiModules: any= {
    home:{
      url:environment.api_url + '/home/',
      methods:[
        {name: 'list', type:'get', url:'home-page-details'},
      ]
    },
    platform:{
      url:environment.api_url + '/platform/',
      methods:[
        {name: 'list', type:'get', url:'platform-page-details'},
      ]
    },
    advisors:{
      url:environment.api_url + '/advisors/',
      methods:[
        {name: 'list', type:'get', url:'advisors-page-details'},
      ]
    },
    recordkeeper:{
      url:environment.api_url + '/recordkeeper/',
      methods:[
        {name: 'list', type:'get', url:'recordkeeper-page-details'},
      ]
    },
    asset_managers:{
      url:environment.api_url + '/asset-managers/',
      methods:[
        {name: 'list', type:'get', url:'asset-managers-page-details'},
      ]
    },
    about_us:{
      url:environment.api_url + '/about-us/',
      methods:[
        {name: 'list', type:'get', url:'about-page-details'},
      ]
    },
    capture_registration:{
      url:environment.api_url + '/capture/',
      methods:[
        {name: 'create', type:'post', url:'registration'},
      ]
    },
    footer:{
      url:environment.api_url + '/footer/',
      methods:[
        {name: 'list', type:'get', url:'footer-details'},
      ]
    },
    
  }

}
