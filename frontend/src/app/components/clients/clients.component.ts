import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-clients',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './clients.component.html',
  styleUrl: './clients.component.css'
})
export class ClientsComponent implements OnInit{
  clients:any[]=[];

  constructor(private http: HttpClient) {

  }


  ngOnInit(): void {
    this.getAllClients();
  }

  getAllClients() {
    this.http.get('http://127.0.0.1:8000/api/v1/clients').subscribe((res:any) => {
      this.clients = res.data;

      console.log('Clients:', this.clients);
    }, error => {
      alert("Error From API")
    });
  }

  toggleApprove(clientId: number) {
    const clientToUpdate = this.clients.find(client => client.id === clientId);
    if (!clientToUpdate) {
      console.error('Client not found with ID:', clientId);
      return;
    }

    const currentApprovalStatus = clientToUpdate.approval_status;
    const newApprovalStatus = currentApprovalStatus === 1 ? 0 : 1;

    this.http.patch(`http://127.0.0.1:8000/api/v1/clients/${clientId}/approve`, null)
      .subscribe(
        (res: any) => {
          clientToUpdate.approval_status = newApprovalStatus;
        },
        (error) => {
          console.error('Error toggling approval:', error);
        }
      );
  }


}
