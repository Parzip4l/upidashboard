<div class="team-member border p-3 mb-3" style="background-color: #f9f9f9;">
    <label for="team_compositions[{{ $index }}][name]">Member Name</label>
    <input type="text" name="team_compositions[{{ $index }}][name]" 
           id="team_compositions[{{ $index }}][name]" class="form-control" 
           value="{{ $member->name ?? '' }}" required>

    <label for="team_compositions[{{ $index }}][role]" class="mt-2">Role</label>
    <input type="text" name="team_compositions[{{ $index }}][role]" 
           id="team_compositions[{{ $index }}][role]" class="form-control" 
           value="{{ $member->role ?? '' }}" required>

    <label for="team_compositions[{{ $index }}][type]" class="mt-2">Type</label>
    <select name="team_compositions[{{ $index }}][type]" 
            id="team_compositions[{{ $index }}][type]" class="form-control" required>
        <option value="student" {{ (isset($member) && $member->type == 'student') ? 'selected' : '' }}>Student</option>
        <option value="faculty" {{ (isset($member) && $member->type == 'faculty') ? 'selected' : '' }}>Faculty</option>
    </select>
</div></select>
</div>