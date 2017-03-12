import { Component } from '@angular/core';
import {DomSanitizer, SafeUrl} from '@angular/platform-browser';

import {GeneratingRequestService} from './generating-request/generating-request.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  text: String;
  pdfviewer: SafeUrl;


  constructor(private sanitizer: DomSanitizer, private generatingRequestService: GeneratingRequestService) {

    //Set the iframe to standard blank
    this.pdfviewer = this.sanitizer.bypassSecurityTrustResourceUrl('about:blank');
  }



  generatingPDF() {
    this.generatingRequestService.generatingPDF(this.text)
      .subscribe(
      res => {
        var fileURL = URL.createObjectURL(res);

        this.pdfviewer = this.sanitizer.bypassSecurityTrustResourceUrl(fileURL);//this.sanitizer.bypassSecurityTrustUrl(fileURL);
      },
      error => console.log(<any>error)
      )
  }


  changeTab(e) {
    if (e.index == 1) {//PDF tab

      if (this.text != null)
        this.generatingPDF();
    }
  }

}
