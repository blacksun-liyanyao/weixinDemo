<?php
class ProductAction extends Action{
	public function product(){
        $news = M('Send');
        if(empty($_GET['page']))
        {
            $page = 1;
        }
        else{
            $page = $_GET['page'];
        }
		$count  = $news->count();
        $total=ceil($count/3);
        if($page>$total)
        {
            $page = $total;
        }
		$res = $news->group("date desc,id desc")->page($page,3)->select();
        $this->assign('data',$res);
        $this->assign('page',$page);// 赋值分页输出
		$this->display();
	}
	public function send(){
		$this->display();
	}
	public function upload() {
    import('ORG.Net.UploadFile');
    $upload = new UploadFile();// 实例化上传类
    $upload->maxSize  = 3145728 ;// 设置附件上传大小
    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->savePath = './Public/images/';// 设置附件上传目录
    if(!$upload->upload()) {// 上传错误提示错误信息
        $this->error($upload->getErrorMsg());
    }else{// 上传成功
        $this->success('上传成功！');
    }
    $model = M('Send');
    $info = $upload->getUploadFileInfo();
    $data['title'] = $_POST['title'];
    $data['href'] = $_POST['href'];
    $data['jianjie'] = $_POST['jianjie'];
    $data['date'] = $_POST['date'];
    $data['file_src'] = $info[0]['savepath'].$info[0]['savename'];
    $model->add($data);
 }
 public function size(){
    $size = "324*";
    for($i=0;$i<849;$i++)
    {
        $sum.=$size.$i.",";
        echo $sum;
    }
 }
}
?>