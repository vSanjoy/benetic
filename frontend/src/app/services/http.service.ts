import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';
import { GlobalConstantService } from './global-constant.service';
import { catchError, tap, mergeMap } from 'rxjs/operators';
import { Observable, of, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HttpService {
	protected base_url: string = this.constant.API_URL;

  protected module: any;
  protected httpOptions: any;

  constructor(
    private http: HttpClient,
    private constant: GlobalConstantService,
    private router: Router
  ) {
    this.httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json',
        // 'Authorization':localStorage.getItem('token')? localStorage.getItem('token'):'',
      })
    };
  }

  public setModule(moduleName: string) {
    this.module = null;
    if (moduleName in this.constant.apiModules) {
      this.module = this.constant.apiModules[moduleName];
      this.httpOptions = {
        headers: new HttpHeaders({
          'Content-Type': 'application/json' ,
          // 'Authorization': localStorage.getItem('token')?localStorage.getItem('token'):'',  
        })
      };
    }
    return this;
  }

  private getReq(url): Observable<any> {
    // console.log('get request');
    return this.http.get<any>(url, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Get one data based on id'))
    );
  }

  private postReq(url, params): Observable<any> {
    // console.log('post request');
    return this.http.post<any>(url, params, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Save data with params'))
    );
  }

  private putReq(url, params): Observable<any> {
    // console.log('put request');
    return this.http.put<any>(url, params, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Update data with params'))
    );
  }

  private deleteReq(url): Observable<any> {
    // console.log('delete request');
    return this.http.delete<any>(url, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Delete data with params'))
    );
  }

  private patchReq(url, params): Observable<any> {
    // console.log('patch request');
    return this.http.patch<any>(url, params, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Delete data with params'))
    );
  }

  buildRequestByMethod(methodName: string, urlParamStr: string = '', paramsObj: any = null ): Observable<any> {  
    if (!this.module) {
      return throwError({
        error: {
          message: 'Module not found!'
        }
      });
    }
    
    const method = this.module.methods.find((el) => {
      return (el.name === methodName);
    });
    
    let url = this.module ? this.module.url : '';
    if (method) {
      url += method.url;
    }
    url += urlParamStr;

    if (method) {
      switch (method.type) {
        case 'get':
          return this.getReq(url);
        case 'post':
          return this.postReq(url, paramsObj);
        case 'delete':
          return this.deleteReq(url);
        case 'put':
          return this.putReq(url, paramsObj);
        case 'patch':
          return this.patchReq(url, paramsObj);
        default:
          return throwError({
            error: {
              message: 'Definition not found in configuration'
            }
          });
      }
    } else {
      return throwError({
        error: {
          message: 'Definition not found in configuration'
        }
      });
    }
  }

  findOne(id: string, optParams: any = null): Observable<any> {
    // console.log('find one');
    let url = '';
    if (!id) {
      return throwError({
        error: {
          message: 'Id not found'
        }
      });
    }
    url += '/' + id;
    const routeParams = optParams || {};
    url += this.__objectToUrl(routeParams);

    return this.buildRequestByMethod('details', url);
  }

  search(params: any): Observable<any> {
    // console.log('search');
    let url = '';
    url += this.__objectToUrl(params);
    return this.buildRequestByMethod('list', url);
  }

  list(params: any): Observable<any> {
    // console.log('list');
    let url = this.module ? this.module.url : '';
    if (this.module) {
      const method = this.module.methods.filter((element) => (element.name === 'list'));
      url += method[0].url;
    }
    url += this.__objectToUrl(params);
    return this.http.get<any>(url, this.httpOptions).pipe(
      tap((data: any) => {
        return data;
      }),
      catchError(this.handleError<any>('Get all data based on query'))
    );
  }

  post(method,params:any):Observable<any>{
    // console.log('post');
    const url = '';
    return this.buildRequestByMethod(method, url, params);
  }

  create(params: any): Observable<any> {
    // console.log('create');
    const url = '';
    return this.buildRequestByMethod('create', url, params);
  }

  update(params: any): Observable<any> {
    // console.log('update');
    let url = '';
    if (!('id' in params)) {
      return throwError({
        error: {
          message: 'Id not found'
        }
      });
    }
    url += '/' + params['id'];
    return this.buildRequestByMethod('update', url, params);
  }

  deleteOne(params: any): Observable<any> {
    // console.log('delete one');
    let url = '';
    if (!('id' in params)) {
      return throwError({
        error: {
          message: 'Id not found'
        }
      });
    }
    url += '/' + params['id'];
    delete params.id;
    url += this.__objectToUrl(params);
    return this.buildRequestByMethod('delete', url);
  }

  setLastActivateTime() {
    const curTs = (new Date()).getTime();
    localStorage.setItem('last-active-time', curTs.toString());
  }

  getLastActivateTime(): Observable<any> {
    const lastTime = localStorage.getItem('last-active-time') || null;
    if (lastTime) {
      const curTs = (new Date()).getTime();
      const diff = (curTs - parseInt(lastTime, 10));
      const seconds = (diff /  1000);
      const minutes = (diff / (60 * 1000));
      const hours = (diff / (60 * 60 * 1000));
      return of({
        lastActiveTime: parseInt(lastTime, 10),
        diffObj: {
          milliseconds: diff,
          seconds: Math.round(seconds),
          minutes: Math.round(minutes),
          hours: Math.round(hours),
        }
      });
    }
    return of(lastTime);
  }

  private __objectToUrl(dataParams: any): string {
    let url = '';
    if (Object.keys(dataParams).length > 0) {
      Object.keys(dataParams).forEach((key, k) => {
        if (dataParams[key]) {
          url += (k === 0) ? '?' : '&';
          url += key + '=' + encodeURI(dataParams[key]);
        }
      });
    }
    return url;
  }

  public handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      throw error;
    };
  }

}
