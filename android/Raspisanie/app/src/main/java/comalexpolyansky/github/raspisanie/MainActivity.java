package comalexpolyansky.github.raspisanie;

import android.app.Activity;
import android.support.v4.widget.SwipeRefreshLayout;
import android.os.Bundle;
import android.util.Log;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.Spinner;



public class MainActivity extends Activity implements SwipeRefreshLayout.OnRefreshListener {
    private String[] group = {"16тп", "17тп", "18тп", "19тп"};
    private String[] week = {"Четная", "Нечетная"};
    private String[] day = {"Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"};
    private ListView listView;
    public static SwipeRefreshLayout swipeLayout;
    private Spinner spinnerGr;
    private Spinner spinnerWeek;
    private Spinner spinnerDay;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        spinnerGr = (Spinner) findViewById(R.id.spinner1);
        spinnerWeek = (Spinner) findViewById(R.id.spinner2);
        spinnerDay = (Spinner) findViewById(R.id.spinner3);
        swipeLayout = (SwipeRefreshLayout) findViewById(R.id.swipe_container);
        swipeLayout.setOnRefreshListener(this);
        swipeLayout.setColorScheme(android.R.color.holo_blue_bright,
                android.R.color.holo_green_light,
                android.R.color.holo_orange_light,
                android.R.color.holo_red_light);

        listView = (ListView) findViewById(android.R.id.list);

        ArrayAdapter<String> adapterGr = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, group);
        adapterGr.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        ArrayAdapter<String> adapterWeek = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, week);
        adapterWeek.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        ArrayAdapter<String> adapterDay = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, day);
        adapterDay.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);


        spinnerGr.setAdapter(adapterGr);
        spinnerGr.setPrompt("Группа");

        spinnerWeek.setAdapter(adapterWeek);
        spinnerWeek.setPrompt("Неделя");

        spinnerDay.setAdapter(adapterDay);
        spinnerDay.setPrompt("День");
        goRefresh();
    }
    public void goRefresh(){
        String day = (spinnerDay.getSelectedItemId()+1)+"";
        String group = spinnerGr.getSelectedItem().toString();
        String w = spinnerWeek.getSelectedItem().toString();
        Log.i("123",w);
        String week;

        if(w.equals("Четная")){
            week = "2";
        }else{
            week = "1";
        }
        new DownloadFilesTask(this, listView).execute("http://raspandr.16mb.com/getRasp.php", day, week, group);
    }
    @Override
    public void onRefresh() {
        goRefresh();
    }
}
