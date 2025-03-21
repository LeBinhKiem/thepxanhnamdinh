<?php

namespace Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Enums\FileEnum;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Accounts\Http\Requests\AdminRegisterRequest;
use Modules\Accounts\Http\Requests\AdminRequest;
use Modules\Accounts\Http\Services\AdminService;
use Modules\Accounts\Models\Enums\AdminEnum;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Base\Http\Traits\ReponseTrait;

class AdminController extends Controller
{
    private $adminService;

    use ReponseTrait;
    use FilterBuilderTrait;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "status", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "email", "=");
        $this->setFilter($request, "phone_number", "=");
        $this->setOrder($request, "updated_at");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items        = $this->adminService->getAll($filters, $orders);
        $query        = $request->query();
        $adminCurrent = get_admin();
        $isSuperAdmin = $adminCurrent->permission == AdminEnum::SUPER_ADMIN;
        $isNomarAdmin = $adminCurrent->permission == AdminEnum::NORMAL_ADMIN;

        $viewData = [
            "items"        => $items,
            "query"        => $query,
            "isSuperAdmin" => $isSuperAdmin,
            "isNomarAdmin" => $isNomarAdmin,
        ];

        return view("accounts::pages.admin.index")->with($viewData);
    }

    public function create()
    {
        return view("accounts::pages.admin.create");
    }

    public function edit($id)
    {
        $item = $this->adminService->findByID($id);

        if ($item->permission == AdminEnum::SUPER_ADMIN) {
            toastr()->warning("Không có quyền truy cập tài khoản super admin", "Cảnh báo");
            return redirect()->route("get.admin.index");
        }

        $viewData["item"] = $item;

        return view("accounts::pages.admin.edit")->with($viewData);
    }

    public function store(AdminRegisterRequest $request)
    {
        $datas             = $request->except("_token", "rdo_option");
        $datas["password"] = bcrypt(AdminEnum::PASSWORD_DEFAULT);

        $reponse = $this->adminService->insert($datas);

        if ($reponse) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route('get.admin.index');
        }

        return redirect()->back();
    }

    public function updateRegister(AdminRegisterRequest $request)
    {
        $datas = $request->except("_token", "rdo_option", "id");
        $id    = $request->id;

        $reponse = $this->adminService->updateByID($id, $datas);

        if ($reponse) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route('get.admin.index');
        }

        return redirect()->back();
    }

    public function setting(Request $request)
    {
        $admin = get_admin();
        $query = $request->query();

        $viewData = [
            "admin" => $admin,
            "query" => $query,
        ];

        return view('accounts::pages.admin.setting')->with($viewData);
    }

    public function update(AdminRequest $request)
    {
        $id   = get_admin_id();
        $data = $request->all();

        $update = $this->adminService->updateByID($id, $data);

        if (!$update) {
            return $this->reponseError("Cập nhật thông tin thất bại");
        }

        $data["urlReload"] = route("get.admin.setting", ["tab" => "infor"]);

        return $this->reponseSucess("Cập nhật thông tin thành công", $data);
    }

    public function updateLogo(Request $request)
    {
        $admin = get_admin();

        $file = FileUploaderService::getInstance()
            ->setExtension(FileEnum::EXTENSION_IMAGE)
            ->uploadOnlyFile($request->file)
            ->removeFile($admin->logo);

        $nameFile = $file->getUrlFileUpload()["data"];

        if (sizeof($file->getError()) > 0) {
            toastr()->error($file->getError()[0], "Có lỗi xảy ra");
            return redirect()->back();
        }

        $data['logo'] = $nameFile;

        $update = $this->adminService->updateByID($admin->id, $data);

        if (!$update) {
            toastr()->error("Cập nhật ảnh thất bại");
        } else {
            toastr()->success("Cập nhật ảnh thành công");
        }

        return redirect()->back();
    }

    public function updatePassword($id)
    {
        return view("accounts::pages.admin.update_password_sa")->with(["id" => $id]);
    }

    public function updatePasswordBySuperAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8',
        ], [
            "new_password.required" => "Yêu cầu nhập dữ liệu",
            "new_password.min"      => "Mật khẩu phải lớn hơn 8 kí tự",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(["errors" => $validator->errors()]);
        }

        $newPassword              = $request->new_password ?? "";
        $id                       = $request->id;
        $dataPassword["password"] = bcrypt($newPassword);

        $update = $this->adminService->updateByID($id, $dataPassword);

        if (!$update) {
            toastr()->error("Thay đổi mật khẩu thất bại");
        } else {
            toastr()->success("Thay đổi mật khẩu thành công");
        }

        return redirect()->back();
    }
    
    public function updatePasswordMyAccount(Request $request)
    {
        $admin            = get_admin();
        $oldPassword      = $request->old_password ?? "";
        $newPassword      = $request->new_password ?? "";
        $newPasswordAgain = $request->new_password_again ?? "";

        if ($newPassword != $newPasswordAgain) {
            return $this->reponseError("Mật khẩu mới phải trùng nhập lại mật khẩu");
        }

        if (!Hash::check($oldPassword, $admin->password)) {
            return $this->reponseError("Thay đổi mật khẩu thất bại");
        }

        $dataPassword["password"] = bcrypt($newPassword);

        $update = $this->adminService->updateByID($admin->id, $dataPassword);

        if (!$update) {
            return $this->reponseError("Thay đổi mật khẩu thất bại");
        }

        $data["urlReload"] = route("get.admin.setting", ["tab" => "infor"]);

        return $this->reponseSucess("Thay đổi mật khẩu thành công", $data);
    }
}