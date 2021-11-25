import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecordkeepersComponent } from './recordkeepers.component';

describe('RecordkeepersComponent', () => {
  let component: RecordkeepersComponent;
  let fixture: ComponentFixture<RecordkeepersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RecordkeepersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(RecordkeepersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
