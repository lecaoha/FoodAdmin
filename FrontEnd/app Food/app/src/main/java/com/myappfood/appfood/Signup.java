package com.myappfood.appfood;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.myappfood.appfood.Common.Common;
import com.myappfood.appfood.Model.User;
import com.rengwuxian.materialedittext.MaterialEditText;

public class Signup extends AppCompatActivity {
    EditText editPhone, editPass, editName;
    TextView backLogin;
    Button btnSignup;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);

        editPass = (EditText) findViewById(R.id.editPass);
        editPhone = (EditText) findViewById(R.id.editPhone);
        editName = (EditText) findViewById(R.id.editName);
        btnSignup = (Button) findViewById(R.id.btnSignup);
        backLogin = findViewById(R.id.backLogin);

        backLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(Signup.this, Signin.class));
            }
        });

        // Khởi tạo Firebase
        FirebaseDatabase database = FirebaseDatabase.getInstance("https://appfood-9abc2-default-rtdb.asia-southeast1.firebasedatabase.app");
        DatabaseReference table_user = database.getReference("User");

        btnSignup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (Common.isConnectedToInterner(getBaseContext())) {
                    final ProgressDialog mDialog = new ProgressDialog(Signup.this);
                    mDialog.setMessage("Please wait...");
                    mDialog.show();

                    final String phonenumber = editPhone.getText().toString();

                    // Kiểm tra xem số điện thoại đã được đăng ký trước đó hay chưa
                    table_user.addListenerForSingleValueEvent(new ValueEventListener() {
                        @Override
                        public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                            if (dataSnapshot.hasChild(phonenumber)) {
                                mDialog.dismiss();
                                Toast.makeText(Signup.this, "Phone Number already registered", Toast.LENGTH_SHORT).show();
                            } else {
                                mDialog.dismiss();
                                User user = new User(editName.getText().toString(), editPass.getText().toString(), editPhone.getText().toString());
                                table_user.child(phonenumber).setValue(user);
                                Toast.makeText(Signup.this, "Sign up successful!", Toast.LENGTH_SHORT).show();
                                finish();
                            }
                        }

                        @Override
                        public void onCancelled(@NonNull DatabaseError error) {
                            mDialog.dismiss();
                            Toast.makeText(Signup.this, "Database Error: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    });
                } else {
                    Toast.makeText(Signup.this, "Please check your connection!", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
}
