namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use app\models\Tgusers;
use yii\web\UploadedFile;

class XatController extends Controller
{
    public function actionUpload()
    {
        $model = new UploadForm();
	$model2 = new Tgusers();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {                
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
    
    $u1 = $key->tgid;
    
    $url = "https://api.telegram.org/bot733884207:AAGaPyZCP-XhP7yeU9fnRcfLq6emaiwF1Zs/sendMessage?chat_id=697841204&text=salom";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    
     
        }

        return $this->render('upload', ['model' => $model]);
    }
}