package com.myappfood.appfood.ViewHolder;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.myappfood.appfood.Common.Common;
import com.myappfood.appfood.Model.User;
import com.myappfood.appfood.R;

public class Signin extends AppCompatActivity {
    EditText editPhone,editPass;
    Button btnsignIn;
    TextView creatMk,quenMk;
    User user;
    DatabaseReference table_user;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_lognin);

        editPass=(EditText) findViewById(R.id.editPass);
        editPhone=(EditText) findViewById(R.id.editPhone);

        btnsignIn=(Button) findViewById(R.id.btnSignin);
        creatMk = findViewById(R.id.creatTk);
        quenMk = findViewById(R.id.quenMk);



        //init firecase
         FirebaseDatabase database= FirebaseDatabase.getInstance("https://appfood-9abc2-default-rtdb.asia-southeast1.firebasedatabase.app");
         table_user= database.getReference("User");

        loadUserInfo();

        btnsignIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                if (Common.isConnectedToInterner(getBaseContext())) {

                    final ProgressDialog mDialog = new ProgressDialog(Signin.this);
                    mDialog.setMessage("Please waiting...");
                    mDialog.show();
                    table_user.addListenerForSingleValueEvent(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot) {
                            //user not exist
                            if (dataSnapshot.child(editPhone.getText().toString()).exists()) {
                                //get user
                                mDialog.dismiss();
                                User user = dataSnapshot.child(editPhone.getText().toString()).getValue(User.class);
                                user.setPhone(editPhone.getText().toString());
                                if (user.getPassword().equals(editPass.getText().toString())) {
                                    saveUserInfo(editPhone.getText().toString(), editPass.getText().toString());

//                                    Intent intent = new Intent(Signin.this, Home.class);
                                    Common.currentUser = user;
//                                    startActivity(intent);
                                    finish();

                                    table_user.removeEventListener(this);

                                } else {
                                    Toast.makeText(Signin.this, "Check Password", Toast.LENGTH_SHORT).show();
                                }
                            } else {
                                mDialog.dismiss();
                                Toast.makeText(Signin.this, "User not Exist", Toast.LENGTH_SHORT).show();
                            }
                        }

                        @Override
                        public void onCancelled(DatabaseError error) {

                        }
                    });
                }else {
                    Toast.makeText(Signin.this, "Please check your connect!", Toast.LENGTH_SHORT).show();
                    return;
                }
            }
        });

        creatMk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(Signin.this,Signup.class));
            }
        });

            }
    private void saveUserInfo(String phone, String password) {
        SharedPreferences sharedPreferences = getSharedPreferences("MyPrefs", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString("phone", phone);
        editor.putString("password", password);
        editor.apply();
    }
    private void loadUserInfo() {
        SharedPreferences sharedPreferences = getSharedPreferences("MyPrefs", Context.MODE_PRIVATE);
        String phone = sharedPreferences.getString("phone", "");
        String password = sharedPreferences.getString("password", "");

        // Kiểm tra nếu đã lưu thông tin đăng nhập thì tự động đăng nhập
        if (!phone.isEmpty() && !password.isEmpty()) {
            // Thực hiện đăng nhập tự động ở đây
            editPhone.setText(phone);
            editPass.setText(password);
            // Gọi hàm đăng nhập ở đây (hoặc sao bạn muốn thực hiện đăng nhập)
            performSignIn(phone, password);
        }
    }
    private void performSignIn(String phone, String password) {
        final ProgressDialog mDialog = new ProgressDialog(Signin.this);
        mDialog.setMessage("Please wait...");
        mDialog.show();

        table_user.addListenerForSingleValueEvent(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                // Kiểm tra xem user có tồn tại trong Firebase Realtime Database không
                if (dataSnapshot.child(phone).exists()) {
                    mDialog.dismiss();
                    user = dataSnapshot.child(phone).getValue(User.class);
                    user.setPhone(phone);
                    if (user.getPassword().equals(password)) {
//                        Intent intent = new Intent(Signin.this, Home.class);
                        Common.currentUser = user;
//                        startActivity(intent);
                        finish();
                    } else {
                        Toast.makeText(Signin.this, "Check Password", Toast.LENGTH_SHORT).show();
                    }
                } else {
                    mDialog.dismiss();
                    Toast.makeText(Signin.this, "User not Exist", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onCancelled(DatabaseError error) {
                // Xử lý lỗi nếu cần
            }
        });
    }

}
