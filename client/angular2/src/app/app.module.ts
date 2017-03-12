import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import { EditorModule,SharedModule,ButtonModule,TabViewModule } from 'primeng/primeng';

import { GeneratingRequestService } from './generating-request/generating-request.service'

import { AppComponent } from './app.component';

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    EditorModule,
    SharedModule,
    ButtonModule,
    TabViewModule
  ],
  providers: [GeneratingRequestService],
  bootstrap: [AppComponent]
})
export class AppModule { }
