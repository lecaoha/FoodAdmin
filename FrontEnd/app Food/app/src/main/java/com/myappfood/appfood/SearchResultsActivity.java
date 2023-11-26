package com.myappfood.appfood;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.SearchView;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.content.Intent;
import android.os.Bundle;
import android.os.PersistableBundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.Toast;

import com.firebase.ui.database.FirebaseRecyclerAdapter;
import com.firebase.ui.database.FirebaseRecyclerOptions;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.Query;
import com.mancj.materialsearchbar.MaterialSearchBar;
import com.myappfood.appfood.Common.Common;
import com.myappfood.appfood.Database.Database;
import com.myappfood.appfood.Interface.ItemClickListener;
import com.myappfood.appfood.Model.Food;
import com.myappfood.appfood.Model.Order;
import com.myappfood.appfood.ViewHolder.FoodViewHolder;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class SearchResultsActivity extends AppCompatActivity {

    RecyclerView recycler_food;
    RecyclerView.LayoutManager layoutManager;

    int mCartItemCount = 10;

    FirebaseDatabase database;
    DatabaseReference foodList;

    FirebaseRecyclerAdapter<Food, FoodViewHolder> adapter;
    FirebaseRecyclerAdapter<Food, FoodViewHolder> searchAdApter;


    Database localDB;

    SwipeRefreshLayout swipeRefreshLayout;
    SearchView searchView;

    //search
    List<String> suggestList = new ArrayList<>();
    MaterialSearchBar materialSearchBar;
    RecyclerView searchRecycler;
    ImageView backImg;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search_results2);

        String query = getIntent().getStringExtra("query");

        backImg = findViewById(R.id.backImg);
        swipeRefreshLayout = findViewById(R.id.swipe_layout1);
        SearchView searchView = findViewById(R.id.search_view);

        database = FirebaseDatabase.getInstance("https://appfood-9abc2-default-rtdb.asia-southeast1.firebasedatabase.app/");
        foodList = database.getReference("Foods");

        recycler_food = (RecyclerView) findViewById(R.id.recycler_search_results);
        recycler_food.setHasFixedSize(true);
        GridLayoutManager layoutManager = new GridLayoutManager(this, 1);
        recycler_food.setLayoutManager(layoutManager);

        if (query != null) {
            // Sử dụng query cho tìm kiếm
            searchFood(query);
        }
        // Load all products (Foods) into the RecyclerView
        loadAllFoods();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                // Handle the search query when the user submits
                searchFood(query);
                return true;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                // Handle search query changes while the user is typing
                searchFood(newText);
                return true;
            }
        });
        backImg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(SearchResultsActivity.this,Home.class));
            }
        });


    }

    private void searchFood(String query) {
        FirebaseRecyclerOptions<Food> searchOptions = new FirebaseRecyclerOptions.Builder<Food>()
                .setQuery(foodList.orderByChild("name").startAt(query).endAt(query + "\uf8ff"), Food.class)
                .build();

        FirebaseRecyclerAdapter<Food, FoodViewHolder> searchAdapter = new FirebaseRecyclerAdapter<Food, FoodViewHolder>(searchOptions) {
            @Override
            protected void onBindViewHolder(@NonNull FoodViewHolder viewHolder, int position, @NonNull Food model) {
                // Populate the ViewHolder with data from Firebase
                viewHolder.food_name.setText(model.getName());
                viewHolder.food_price.setText(String.format("$ %s", model.getPrice().toString()));

                Picasso.with(getBaseContext()).load(model.getImage())
                        .into(viewHolder.food_image);
                //quick cart
                viewHolder.quick_cart.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        new Database(getBaseContext()).addToCart(new Order(
                                adapter.getRef(position).getKey(),
                                model .getName(),
                                "1",
                                model.getPrice(),
                                model.getDiscount(),
                                model.getImage()

                        ));
                        Toast.makeText(SearchResultsActivity.this, "Add to Cart", Toast.LENGTH_SHORT).show();

                    }
                });
                //add favorite
//                if (localDB.isFavorite(adapter.getRef(position).getKey()))
//                    viewHolder.fav_image.setImageResource(R.drawable.ic_baseline_favorite_24);
//
//
//                //click favorite
//                viewHolder.fav_image.setOnClickListener(new View.OnClickListener() {
//                    @Override
//                    public void onClick(View v) {
//                        if (!localDB.isFavorite(adapter.getRef(position).getKey()))
//                        {
//                            localDB.addToFavorites(adapter.getRef(position).getKey());
//                            viewHolder.fav_image.setImageResource(R.drawable.ic_baseline_favorite_24);
//                            Toast.makeText(SearchResultsActivity.this, ""+model.getName()+" was add to Favorites", Toast.LENGTH_SHORT).show();
//                        }else {
//                            localDB.removeFromFavorites(adapter.getRef(position).getKey());
//                            viewHolder.fav_image.setImageResource(R.drawable.ic_baseline_favorite_border_24);
//                            Toast.makeText(SearchResultsActivity.this, ""+model.getName()+" was removed to Favorites", Toast.LENGTH_SHORT).show();
//                        }
//                    }
//                });
                // Handle item click
                final Food local = model;
                viewHolder.setItemClickListener(new ItemClickListener() {
                    @Override
                    public void onClick(View view, int position, boolean isLongClick) {
                        // Handle the click event here
                        Intent foodDetail = new Intent(SearchResultsActivity.this, FoodDetail.class);
                        foodDetail.putExtra("FoodId", getRef(position).getKey());
                        startActivity(foodDetail);
                    }
                });
            }

            @NonNull
            @Override
            public FoodViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
                View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.food_item, parent, false);
                return new FoodViewHolder(view);
            }
        };

        recycler_food.setAdapter(searchAdapter);
        searchAdapter.startListening();
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState, @Nullable PersistableBundle persistentState) {
        super.onCreate(savedInstanceState, persistentState);
        //fix click back button category
        if (adapter!= null)
            adapter.startListening();
    }
    @Override
    protected void onStart() {
        super.onStart();
        if (adapter != null) {
            adapter.startListening();
        }
    }

    @Override
    protected void onStop() {
        super.onStop();
        if (adapter != null) {
            adapter.stopListening();
        }
    }
    private void loadAllFoods() {
        FirebaseRecyclerOptions<Food> options = new FirebaseRecyclerOptions.Builder<Food>()
                .setQuery(foodList, Food.class)
                .build();

        adapter = new FirebaseRecyclerAdapter<Food, FoodViewHolder>(options) {
            @Override
            protected void onBindViewHolder(@NonNull FoodViewHolder viewHolder, int position, @NonNull Food model) {
                // Populate the ViewHolder with data from Firebase
                viewHolder.food_name.setText(model.getName());
                viewHolder.food_price.setText(String.format("$ %s", model.getPrice().toString()));

                Picasso.with(getBaseContext()).load(model.getImage())
                        .into(viewHolder.food_image);

                viewHolder.quick_cart.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        new Database(getBaseContext()).addToCart(new Order(
                                adapter.getRef(position).getKey(),
                                model .getName(),
                                "1",
                                model.getPrice(),
                                model.getDiscount(),
                                model.getImage()

                        ));
                        Toast.makeText(SearchResultsActivity.this, "Add to Cart", Toast.LENGTH_SHORT).show();

                    }
                });
                // Handle item click
                final Food local = model;
                viewHolder.setItemClickListener(new ItemClickListener() {
                    @Override
                    public void onClick(View view, int position, boolean isLongClick) {
                        // Handle the click event here
                        Intent foodDetail = new Intent(SearchResultsActivity.this, FoodDetail.class);
                        foodDetail.putExtra("FoodId", adapter.getRef(position).getKey());
                        startActivity(foodDetail);
                    }
                });
            }

            @NonNull
            @Override
            public FoodViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
                View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.food_item, parent, false);
                return new FoodViewHolder(view);
            }
        };

        recycler_food.setAdapter(adapter);
    }

}