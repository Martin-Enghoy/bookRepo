void setup()
{
  pinMode(2, OUTPUT);//DP
  pinMode(3, OUTPUT);//A
  pinMode(4, OUTPUT);//B
  pinMode(5, OUTPUT);//C
  pinMode(6, OUTPUT);//D
  pinMode(7, OUTPUT);//E
  pinMode(8, OUTPUT);//F
  pinMode(9, OUTPUT);//G
  pinMode(10, INPUT_PULLUP);
  pinMode(11, INPUT_PULLUP);
  pinMode(12, INPUT_PULLUP);
  pinMode(13, INPUT_PULLUP);
  pinMode(A1, OUTPUT);//right
  pinMode(A2, OUTPUT);//left
  pinMode(A0, OUTPUT);//buzzer
  Serial.begin(9600);
}

void sevenSeg(int n){
  switch(n){
  	case 0:	digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, HIGH);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, LOW);
			break;
    case 1: digitalWrite(2, LOW);
    		digitalWrite(3, LOW);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, LOW);
    		digitalWrite(7, LOW);
    		digitalWrite(8, LOW);
    		digitalWrite(9, LOW);
			break;
    case 2: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, LOW);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, HIGH);
    		digitalWrite(8, LOW);
    		digitalWrite(9, HIGH);
			break;
    case 3: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, LOW);
    		digitalWrite(8, LOW);
    		digitalWrite(9, HIGH);
			break;
    case 4: digitalWrite(2, LOW);
    		digitalWrite(3, LOW);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, LOW);
    		digitalWrite(7, LOW);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, HIGH);
			break;
    case 5: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, LOW);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, LOW);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, HIGH);
			break;
    case 6: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, LOW);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, HIGH);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, HIGH);
			break;
    case 7: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, LOW);
    		digitalWrite(7, LOW);
    		digitalWrite(8, LOW);
    		digitalWrite(9, LOW);
			break;
    case 8: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, HIGH);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, HIGH);
			break;
    case 9: digitalWrite(2, LOW);
    		digitalWrite(3, HIGH);
    		digitalWrite(4, HIGH);
    		digitalWrite(5, HIGH);
    		digitalWrite(6, HIGH);
    		digitalWrite(7, LOW);
    		digitalWrite(8, HIGH);
    		digitalWrite(9, HIGH);
			break;
    case 10: digitalWrite(2, HIGH);
    		 digitalWrite(3, LOW);
    		 digitalWrite(4, LOW);
    		 digitalWrite(5, LOW);
    		 digitalWrite(6, LOW);
    		 digitalWrite(7, LOW);
    		 digitalWrite(8, LOW);
    		 digitalWrite(9, LOW);
			 break;
    case 910: digitalWrite(2, HIGH);
    		  digitalWrite(3, HIGH);
    		  digitalWrite(4, HIGH);
    		  digitalWrite(5, HIGH);
    		  digitalWrite(6, HIGH);
    		  digitalWrite(7, LOW);
    		  digitalWrite(8, HIGH);
    		  digitalWrite(9, HIGH);
			  break;
    default: break;
  }
}

void light(int digit, int number){//function to display current LED state
  switch(digit){
  	case 1: digitalWrite(A1, HIGH); digitalWrite(A2, LOW); break;
    case 2: digitalWrite(A1, LOW); digitalWrite(A2, HIGH); break;
  } 
  sevenSeg(number);
}

int mD1 = 0, mD2 = 0; //LSB and MSB saved in memory
bool addingState;//checks if the program is at adding state

int D1=0, D2=0; //LSB and MSB respectively
int digit=1; //decide which segment to use
bool lastp10btnState, lastp11btnState, lastp12btnState, lastp13btnState;

void refresh(){ //refresh display
	light(1, D1); delay(5);
  	light(2, D2); delay(5);
}

void btnUpPressed(){//checks if up btn is pressed
  bool p10 = digitalRead(10);
  if(lastp10btnState == p10) return;
  if(digit == 1 && p10 == LOW){//checks if digit 1 is being incremented
  	D1++;
    D1 %= 10;
  }
  if(digit == 2 && p10 == LOW){//checks if digit 2 is being incremented
  	D2++;
    D2 %= 10;
  }
  lastp10btnState = p10;
}

void btnDownPressed(){//checks if up btn is pressed
  bool p11 = digitalRead(11);
  if(lastp11btnState == p11) return;
  if(digit == 1 && p11 == LOW){//checks if digit 1 is being decremented
  	D1--;
    D1 %= 10; if(D1 < 0){D1=9;}
  }
  if(digit == 2 && p11 == LOW){//checks if digit 2 is being decremented
  	D2--;
    D2 %= 10; if(D2 < 0){D2=9;}
  }
  lastp11btnState = p11;  
}

void btnNextPressed(){
  bool p12 = digitalRead(12);//checks if next button  is pressed
  if(lastp12btnState == p12) return;
  if(p12 == LOW){ //checks if next btn is pressed
    switch(digit){
    	case 1: digit = 2; break;
      	case 2: digit = 1; break;
    }
  }
  lastp12btnState = p12;
}

void btnAddPressed(){
  bool p13 = digitalRead(13);//checks if add button is pressed
  if(lastp13btnState == p13) return;
  if(p13 == LOW){
    if(addingState == false){
      mD1 = D1; D1 = 0;//LSB
      mD2 = D2; D2 = 0;//MSB
      addingState = true;
    } else{//get previous digits and add to current digits
       int a1 = mD2 * 10, b1 = D2*10;
       int prevNum  = a1+mD1, currNum = b1+D1;

       int sum = prevNum + currNum;

      if(sum > 99){
          D1 = 910; D2 = 910;
      } else{
          D2 = sum/10;
          D1 = sum%10;
          tone(A0, 1000); delay(1000); noTone(A0);
      }
      addingState = false;
    }
  }
  lastp13btnState = p13;
}

void loop()
{   
  btnUpPressed();
  btnDownPressed();
  btnNextPressed();
  btnAddPressed();
  refresh();
}