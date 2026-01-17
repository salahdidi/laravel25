<?php 
 
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use App\Models\SchoolClass;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    #[Url('class_id')]
    public ?int $class_id = null;

    public $name;
    public $description;
    public bool $isEditMode = false;

    public function load(?int $class_id = null)
    {
        if ($class_id) {
            $class = SchoolClass::find($class_id);
            if ($class) {
                $this->class_id = $class->id;
                $this->name = $class->name;
                $this->description = $class->description;
                $this->isEditMode = true;
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'description' => 'nullable|string',
        ]);

        if ($this->isEditMode) {
            $class = SchoolClass::findOrFail($this->class_id);
            $class->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Class Updated Successfully.');
        } else {
            SchoolClass::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Class Created Successfully.');
        }
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->class_id = null;
        $this->isEditMode = false;
    }

    public function delete($id)
    {
        SchoolClass::findOrFail($id)->delete();
        session()->flash('message', 'Class Deleted Successfully.');
    }
}; 
?>

<div>
    <div>
        <h2>School Class Manager</h2>

        @if (session()->has('message'))
            <div class="alert">
                {{ session('message') }}
            </div>
        @endif

        <!-- Form for Creating/Updating a Class -->
        <form wire:submit.prevent="save">
            <div class="form-group">
                <input type="text" wire:model="name" placeholder="Class Name" class="form-control">
                @error('name') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <textarea wire:model="description" placeholder="Description" class="form-control"></textarea>
                @error('description') <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn">
                    {{ $isEditMode ? 'Update' : 'Create' }}
                </button>
                @if($isEditMode)
                                    btn-cancel">
                                    <button type="button" wire:click="resetFields" class="btn 
                    Cancel 
                    </button> 
                @endif 
    </div> 
    </form> 
<!-- Table Listing School Classes --> 
<table class=" table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\SchoolClass::latest()->get() as $class)
                            <tr>
                                <td>{{ $class->id }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->description }}</td>
                                <td>
                                    <button wire:click="load({{ $class->id }})" class="btn btn-warning">Edit</button>
                                    <button wire:click="delete({{ $class->id }})" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
</div>
