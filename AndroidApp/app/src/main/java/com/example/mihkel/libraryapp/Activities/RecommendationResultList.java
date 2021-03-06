package com.example.mihkel.libraryapp.Activities;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import com.example.mihkel.libraryapp.Interfaces.ParseStringCallBackListener;
import com.example.mihkel.libraryapp.Item.Book;
import com.example.mihkel.libraryapp.Item.Item;
import com.example.mihkel.libraryapp.R;
import com.example.mihkel.libraryapp.Various.AppManagerSingleton;
import com.example.mihkel.libraryapp.Various.DatabaseLayerImpl;
import com.example.mihkel.libraryapp.Various.DatabaseManagerSingleton;
import com.example.mihkel.libraryapp.Various.JsonTask;
import com.example.mihkel.libraryapp.Various.ListAdapter;

import java.util.ArrayList;
import java.util.List;

public class RecommendationResultList extends Activity implements ParseStringCallBackListener {
    ListView listView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_book_list);

        DatabaseLayerImpl databaseLayer = new DatabaseLayerImpl();

        // Get ListView object from xml
        listView = (ListView) findViewById(R.id.schoolsList);
//        List<Item> list = new ArrayList<Item>(databaseLayer.getReadingList(AppManagerSingleton.selectedClassId).values());
        ListAdapter adapter = new ListAdapter(this, R.layout.table_row, DatabaseManagerSingleton.getInstance().getResults());


//            ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
//              android.R.layout.simple_list_item_1, android.R.id.text1, list);


        // Assign adapter to ListView
        listView.setAdapter(adapter);

        // ListView Item Click Listener
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {

                // ListView Clicked item index
                int itemPosition = position;

                // ListView Clicked item value
                Item itemValue = (Item) listView.getItemAtPosition(position);

                // Show Alert
//                Toast.makeText(getApplicationContext(),"Position :" + itemPosition + "  ListItem : " + itemValue, Toast.LENGTH_LONG).show();
                AppManagerSingleton.selectedBookId = itemValue.getId();
//                    Intent calendarStartIntent = new Intent(this, BooksListActivity.class);
//                    startActivity(calendarStartIntent);
//        }

                if (true || !DatabaseManagerSingleton.getInstance().hasBook(AppManagerSingleton.selectedBookId))
                    fetchDataFromServer(itemValue.getId());
                else
                    startResultBookViewActivity();

            }

        });
    }

    public void startResultBookViewActivity() {
        Intent calendarStartIntent = new Intent(this, BookViewActivity.class);
        startActivity(calendarStartIntent);
    }

//    public void fetchDataFromServer(int bookId) {
//        JsonTask jsonTask = new JsonTask(RecommendationResultList.this, null).setListener(this);
//        jsonTask.execute("http://admin-mihkelvilismae.rhcloud.com/AdminInterface/json/Raamat/" + bookId);
//    }
//
//    @Override
//    public void callback(String jsonString, Integer type) {
////        DatabaseManagerSingleton.getInstance().setClassesInSchoolJson(AppManagerSingleton.selectedSchoolId, jsonString);
//        startResultBookViewActivity();
//
//    }

    public void fetchDataFromServer(int bookId) {
        JsonTask jsonTask = new JsonTask(RecommendationResultList.this).setListener(this);
        jsonTask.execute("http://admin-mihkelvilismae.rhcloud.com/AdminInterface/json/Raamat?id=" + bookId);
    }

    @Override
    public void callback(String jsonString, Integer type) {
        DatabaseManagerSingleton.getInstance().setBookInfo(AppManagerSingleton.selectedSchoolId, jsonString);
        startResultBookViewActivity();
    }


}