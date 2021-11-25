import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AssetManagersComponent } from './asset-managers.component';

describe('AssetManagersComponent', () => {
  let component: AssetManagersComponent;
  let fixture: ComponentFixture<AssetManagersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AssetManagersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AssetManagersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
