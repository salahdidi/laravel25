<?php 
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use App\Models\Student;
use App\Models\SchoolClass;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    #[Url('student_id')]
    public ?int $student_id = null;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $date_of_birth;
    public $school_class_id;
    public bool $isEditMode = false;
    public function mount(?int $student_id = null)
    {
        if ($student_id) {
            $student = Student::find($student_id);
            if ($student) {
                $this->student_id
                    = $student->id;
                $this->name = $student->name;
                $this->email = $student->email;
                $this->phone = $student->phone;
                $this->address = $student->address;
                $this->date_of_birth = $student->date_of_birth;
                $this->school_class_id = $student->school_class_id;
                $this->isEditMode = true;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => $this->isEditMode
                ?
                'required|email|unique:students,email,' . $this->student_id
                :
                'required|email|unique:students,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'school_class_id' => 'nullable|exists:school_classes,id',
        ]);

        if ($this->isEditMode) {
            $student = Student::findOrFail($this->student_id);
            $student->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'date_of_birth' => $this->date_of_birth,
                'school_class_id' => $this->school_class_id,
            ]);
            session()->flash('message', 'Student Updated Successfully.');
        } else {
            Student::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'date_of_birth' => $this->date_of_birth,
                'school_class_id' => $this->school_class_id,
            ]);
            session()->flash('message', 'Student Created Successfully.');
        }
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->date_of_birth = '';
        $this->school_class_id = '';
        $this->student_id = null;
        $this->isEditMode = false;
    }

    public function delete($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Student Deleted Successfully.');
    }
}; 
?>



<div>
    <div>
        <h2>Student Manager</h2>

        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif

        <!-- Form for Creating/Updating a Student -->
        <form wire:submit.prevent="save">
            <div class="form-group">
                <input type="text" wire:model="name" placeholder="Student Name" class="form-control">
                @error('name') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" wire:model="email" placeholder="Student 
Email" class="form-control">
                @error('email') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" wire:model="phone" placeholder="Phone" class="form-control">
                @error('phone') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" wire:model="address" placeholder="Address" class="form-control">
                @error('address') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <input type="date" wire:model="date_of_birth" placeholder="Date 
of Birth" class="form-control">
                @error('date_of_birth') <span class="error">{{ $message 
                }}</span> @enderror
            </div>

            <div class="form-group">
                <select wire:model="school_class_id" class="form-control">
                    <option value="">Select Class</option>
                    @foreach(App\Models\SchoolClass::all() as $class)
                                            <option value="{{ $class->id }}">{{ $class->name 
                        }}</option>
                    @endforeach
                </select>
                @error('school_class_id') <span class="error">{{ $message 
                }}</span> @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn">
                    {{ $isEditMode ? 'Update' : 'Create' }}
                </button>
                @if($isEditMode)
                                    <button type="button" wire:click="resetFields" class="btn 
                    btn-cancel">
                                        Cancel
                                    </button>
                @endif
            </div>
        </form>

        <!-- Table Listing Students -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date of Birth</th>
                    <th>Class</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(App\Models\Student::latest()->get() as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->date_of_birth }}</td>
                                <td>{{ $student->schoolClass ? $student->schoolClass
                    > name : '' }}</td>
                                <td>
                                    <button wire:click="mount({{ $student->id }})" class="btn btn-warning">Edit</button>
                                    <button wire:click="delete({{ $student->id }})" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

