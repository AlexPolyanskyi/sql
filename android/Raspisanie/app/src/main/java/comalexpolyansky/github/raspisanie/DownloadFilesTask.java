package comalexpolyansky.github.raspisanie;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import org.apache.http.NameValuePair;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by Алексей on 27.10.2014.
 */
class DownloadFilesTask extends AsyncTask<String, Void, String> {
        private String result = null;
        private ProgressDialog pd;
        private Context context;
        private ListView listView;
    DownloadFilesTask(Context c, ListView v) {
        context = c;
        listView = v;
    }
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pd = new ProgressDialog(context);
            pd.setMessage("Загружаюсь...");
            pd.setIndeterminate(true);
            pd.setCancelable(true);
            pd.show();
        }

        @Override
        protected String doInBackground(String... params) {
            try {
                DefaultHttpClient hc = new DefaultHttpClient();
                ResponseHandler<String> res = new BasicResponseHandler();
                HttpPost postMethod = new HttpPost(params[0]);
                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(3);
                nameValuePairs.add(new BasicNameValuePair("day", params[1]));
                nameValuePairs.add(new BasicNameValuePair("week", params[2]));
                nameValuePairs.add(new BasicNameValuePair("group", params[3]));
                postMethod.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                result = hc.execute(postMethod, res);
            } catch (Exception e) {

            }
            return null;
        }

        @Override
        protected void onPostExecute(String s) {
            super.onPostExecute(s);
            ArrayList<Map<String, Object>> data = new ArrayList<Map<String, Object>>();
            result = result.substring(1);
            Log.i("123", result);
            try {
                JSONObject json = new JSONObject(result);
                JSONArray urls = json.getJSONArray("data");
                HashMap<String, Object> hm;
                for (int i = 0; i < urls.length(); i++){
                    hm = new HashMap<String, Object>();
                    hm.put("subject", urls.getJSONObject(i).getString("subject"));
                    hm.put("prepod", urls.getJSONObject(i).getString("prepod"));
                    hm.put("kabinet", urls.getJSONObject(i).getString("kabinet"));
                    hm.put("number", urls.getJSONObject(i).getString("number"));
                    data.add(hm);


                }
            }catch (Exception e){
                Log.e("1234",e+"");
            }
            SimpleAdapter adapter = new SimpleAdapter(context, data, R.layout.adapter_item,
                    new String[] {"number", "subject", "prepod", "kabinet" }, new int[] { R.id.t1, R.id.t2, R.id.t3, R.id.t4  });

            listView.setAdapter(adapter);
            listView.setChoiceMode(ListView.CHOICE_MODE_SINGLE);
            pd.dismiss();
            if(MainActivity.swipeLayout.isRefreshing()) {
                MainActivity.swipeLayout.setRefreshing(false);
            }
        }
    }
